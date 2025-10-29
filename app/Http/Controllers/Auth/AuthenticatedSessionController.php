<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\OtpVerification;
use App\Models\LoginAttempt;
use App\Mail\OtpMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $adminExists = User::where('role', 'admin')->exists();
        
        // Get lockout information for current session
        $email = old('email');
        $ipAddress = request()->ip();
        $lockoutInfo = null;
        
        if ($email) {
            $lockoutUntil = LoginAttempt::isLockedOut($email, $ipAddress);
            if ($lockoutUntil) {
                $lockoutInfo = [
                    'locked' => true,
                    'until' => $lockoutUntil,
                    'remaining_minutes' => now()->diffInMinutes($lockoutUntil, false)
                ];
            } else {
                $remainingAttempts = LoginAttempt::getRemainingAttempts($email, $ipAddress);
                $lockoutInfo = [
                    'locked' => false,
                    'remaining_attempts' => $remainingAttempts
                ];
            }
        }
        
        return view('auth.login', compact('adminExists', 'lockoutInfo'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
            'role' => ['required', 'in:admin,accountant,plumber,customer'],
        ]);

        $email = $request->email; // May be an email or a customer number
        $password = $request->password;
        $role = $request->role;
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Allow customers to login using either email or customer number (regardless of selected role)
        // Check if input looks like a customer number: YYYY-XXXX or CUST-XXXX
        $isCustomerNumber = (str_starts_with($email, 'CUST-') || preg_match('/^\d{4}-\d{4}$/', $email));
        if ($isCustomerNumber) {
            $customer = User::where('customer_number', $email)->first();
            if (!$customer || $customer->role !== 'customer') {
                // Record failed attempt against the provided identifier
                LoginAttempt::recordFailedAttempt($email, $ipAddress, $userAgent, $latitude, $longitude);
                $remainingAttempts = LoginAttempt::getRemainingAttempts($email, $ipAddress);
                if ($remainingAttempts <= 0) {
                    LoginAttempt::setLockout($email, $ipAddress, 5, $latitude, $longitude);
                    return redirect()->route('login')->with('error', 'Account locked due to too many failed attempts. Please try again in 5 minutes.')->onlyInput('email');
                }
                return redirect()->route('login')->with('error', 'Customer number not found.')->onlyInput('email');
            }
            // Swap to the customer's email for authentication; role will be corrected later if needed
            $email = $customer->email;
            // If the selected role is wrong, it will be corrected by the role-mismatch handler below
        }

        // Check if account is locked out
        $lockoutUntil = LoginAttempt::isLockedOut($email, $ipAddress);
        if ($lockoutUntil) {
            $remainingMinutes = now()->diffInMinutes($lockoutUntil, false);
            return redirect()->route('login')->with('error', "Account is locked. Please try again in {$remainingMinutes} minutes.")->onlyInput('email');
        }

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = auth()->user();

            // Record successful login attempt
            LoginAttempt::recordSuccessfulAttempt($email, $ipAddress, $userAgent, $latitude, $longitude);
            LoginAttempt::clearFailedAttempts($email, $ipAddress);

            // Check if user account is active
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is pending approval. Please wait for admin approval.')->onlyInput('email');
            }

            // If selected role doesn't match, continue login and redirect to the user's actual role dashboard
            // This avoids false "invalid credentials" UX when the role dropdown is wrong
            // We only warn the user via a flash message
            if ($user->role !== $request->role) {
                // Note: We purposely do NOT log out here; we let the user in and route them correctly
                session()->flash('warning', 'Role corrected to '.ucfirst($user->role).'.');
            }

            // Check if user needs verification (exclude admin users)
            if (!$user->isAdmin()) {
                // Check if this is an admin-created account that needs OTP verification
                if ($user->admin_created && $user->email_verified_at === null) {
                    // Generate OTP for admin-created account verification
                    $otp = OtpVerification::generateOtp($user->id, 'login');
                    
                    try {
                        Mail::to($user->email)->send(new OtpMail($user, $otp->otp_code, 'login'));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send OTP email: ' . $e->getMessage());
                    }

                    // Store user ID in session for OTP verification
                    $request->session()->put('otp_user_id', $user->id);
                    $request->session()->put('otp_redirect_route', $this->getRedirectRoute($user->role));
                    
                    // Regenerate session to ensure fresh CSRF token
                    $request->session()->regenerate();
                    
                    Auth::logout(); // Logout until OTP is verified
                    
                    return redirect()->route('otp.verify')->with('success', 'An OTP has been sent to your email. Please verify to continue.');
                } 
                // Check if this is a self-registered user that needs email verification
                else if (!$user->admin_created && $user->email_verified_at === null) {
                    // Use OTP verification for self-registered users after admin approval
                    $otp = OtpVerification::generateOtp($user->id, 'login');

                    try {
                        Mail::to($user->email)->send(new OtpMail($user, $otp->otp_code, 'login'));
                    } catch (\Exception $e) {
                        \Log::error('Failed to send OTP email: ' . $e->getMessage());
                    }

                    // Prepare OTP session details
                    $request->session()->put('otp_user_id', $user->id);
                    $request->session()->put('otp_redirect_route', $this->getRedirectRoute($user->role));

                    // Regenerate session and require OTP before continuing
                    $request->session()->regenerate();
                    Auth::logout();

                    return redirect()->route('otp.verify')->with('success', 'An OTP has been sent to your email. Please verify to continue.');
                }
            }

            // Redirect based on user role
            return redirect()->intended($this->getRedirectRoute($user->role));
        }

        // Record failed login attempt
        LoginAttempt::recordFailedAttempt($email, $ipAddress, $userAgent, $latitude, $longitude);
        $remainingAttempts = LoginAttempt::getRemainingAttempts($email, $ipAddress);
        
        if ($remainingAttempts <= 0) {
            LoginAttempt::setLockout($email, $ipAddress, 5, $latitude, $longitude);
            return redirect()->route('login')->with('error', 'Account locked due to too many failed attempts. Please try again in 5 minutes.')->onlyInput('email');
        }

        return redirect()->route('login')->with('error', 'The provided credentials do not match our records.')->onlyInput('email');
    }

    /**
     * Get redirect route based on user role
     */
    private function getRedirectRoute(string $role): string
    {
        return match($role) {
            'admin' => route('admin.dashboard'),
            'accountant' => route('accountant.dashboard'),
            'plumber' => route('plumber.dashboard'),
            'customer' => route('customer.dashboard'),
            default => route('dashboard')
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
