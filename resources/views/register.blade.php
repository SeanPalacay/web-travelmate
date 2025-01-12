<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelMate</title>
    <link rel="icon" href="{{ asset('assets/Travel.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">
    <style>

        /* Custom tooltip styling */
.tooltip-inner {
    font-size: 0.875rem;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
}

.tooltip.bs-tooltip-end .tooltip-arrow::before {
    border-right-color: red; /* Default color for the arrow */
}

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0b0e1f, #0040ff);
            height: 100vh;
            color: white;
            overflow: hidden;
        }

        h1,
        h2,
        h3 {
            font-family: 'Bangers', cursive;
        }

        .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100vh;
            padding: 0 30px;
        }

        .left-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        /* Adjusted the logo size and text size */
        .left-content img {
            max-width: 400px;
            height: auto;
        }

        .left-content h1 {
            font-size: 8rem;
            margin-top: 20px;
            text-align: left;
        }

        .left-content p {
            font-size: 2rem;
            font-weight: 700;
            text-align: left;
            max-width: 550px;
        }

        .right-content {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            background-color: white;
            padding: 30px;
            max-width: 700px;
            width: 100%;
        }

        .btn-custom {
            background-color: #0d6efd;
            color: #ffffff;
            border-radius: 20px;
            padding: 12px 18px;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.1rem;
        }

        .btn-custom:hover {
            background-color: #0b5ed7;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .input-group-text {
            background-color: #0d6efd;
            color: #ffffff;
            border: none;
            border-radius: 15px 0 0 15px;
        }

        .input-group {
            margin-bottom: 1.2rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"] {
            border-radius: 15px;
            border: 1px solid #ced4da;
            padding: 0.9rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="date"]:focus {
            outline: none;
            border-color: #0d6efd;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-weight: 700;
            color: #0d6efd;
            margin-bottom: 1.8rem;
            font-size: 2.5rem;
            text-align: center;
        }

        .text-primary:hover {
            text-decoration: underline;
        }

        .btn-custom {
            width: 100%;
            background-color: #0d6efd;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #0b5ed7;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Error message styling */
        .is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875rem;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .left-content h1 {
                font-size: 5rem;
                /* Adjusted size for smaller screens */
            }

            .left-content p {
                font-size: 1.2rem;
                /* Adjusted size for smaller screens */
            }

            .card {
                max-width: 100%;
                /* Ensure form takes full width */
            }
        }
    </style>
</head>

<body>
    <div class="container content-wrapper">
        <!-- Left Content (Logo and Text) -->
        <div class="left-content">
            <img src="{{ asset('assets/Travel.png') }}" alt="TravelMate Logo">
            <h1>TRAVELMATE</h1>
            <p>Explore the world with us. Login to manage your trips or register to start your adventure.</p>
        </div>

        <!-- Right Content (Form) -->
        <div class="right-content">
            <div class="card bg-light">
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif
                <h2 class="form-title">Create your account</h2>
                <form action="/register-account" method="POST" class="row g-3">
                    @csrf
                    <input type="hidden" value="owner" name="type">

                    <!-- First Name -->
                    <div class="col-md-6">
                        <label for="firstname" class="form-label">First Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-user"></i></span>
                            <input type="text" class="form-control @error('firstname') is-invalid @enderror"
                                id="firstname" name="firstname" placeholder="John" value="{{ old('firstname') }}">
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label for="lastname" class="form-label">Last Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-user"></i></span>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                                id="lastname" name="lastname" placeholder="Doe" value="{{ old('lastname') }}">
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="test@email.com" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Business Name -->
                    <div class="col-md-6">
                        <label for="business_name" class="form-label">Business Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-briefcase"></i></span>
                            <input type="text" class="form-control @error('business_name') is-invalid @enderror"
                                id="business_name" name="business_name" placeholder="Business Inc."
                                value="{{ old('business_name') }}">
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Locality -->
                    <div class="col-md-6">
                        <label for="locality" class="form-label">Locality</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-map-marker"></i></span>
                            <input type="text" class="form-control @error('locality') is-invalid @enderror"
                                id="locality" name="locality" placeholder="Locality" value="{{ old('locality') }}">
                            @error('locality')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Mobile No -->
                    <div class="col-md-6">
                        <label for="mobile_no" class="form-label">Mobile No</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-phone"></i></span>
                            <input type="text" 
                                   class="form-control @error('mobile_no') is-invalid @enderror"
                                   id="mobile_no" 
                                   name="mobile_no" 
                                   placeholder="+639XXXXXXXXX"
                                   maxlength="13"
                                   value="{{ old('mobile_no', '+639') }}">
                            @error('mobile_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                        
                    <!-- Birthdate -->
                    <div class="col-md-6">
                        <label for="birthdate" class="form-label">Birthdate</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-calendar"></i></span>
                            <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


<!-- Password -->
<div class="col-md-6">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
        <span class="input-group-text"><i class="lni lni-lock"></i></span>
        <input type="password" class="form-control @error('password') is-invalid @enderror"
            id="password" name="password" placeholder="Password" value="{{ old('password') }}"
            data-bs-toggle="tooltip" data-bs-placement="right">
        <span class="input-group-text" id="togglePassword">
            <i class="lni lni-eye" id="togglePasswordIcon"></i>
        </span>
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

                    <!-- Confirm Password -->
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="lni lni-lock"></i></span>
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" placeholder="Confirm Password"
                                value="{{ old('password_confirmation') }}">
                            <span class="input-group-text" id="toggleConfirmPassword">
                                <i class="lni lni-eye" id="toggleConfirmPasswordIcon"></i>
                            </span>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12">
                        <button class="btn btn-custom">Register</button>
                    </div>
                </form>
                <p class="text-center mt-3">Already have an account? <a href="/" class="text-primary">Log in here</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap tooltip
    const passwordInput = document.getElementById('password');
    const passwordTooltip = new bootstrap.Tooltip(passwordInput, {
        placement: 'right', // Position the tooltip to the right of the input
        trigger: 'manual', // Manually control tooltip visibility
    });

    // Variable to track the current tooltip state
    let isTooltipVisible = false;

    // Password strength validation
    passwordInput.addEventListener('input', function (e) {
        const password = e.target.value;

        // Define password strength rules
        const minLength = 8;
        const hasUppercase = /[A-Z]/.test(password);
        const hasLowercase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        // Check password strength
        let strength = 0;
        if (password.length >= minLength) strength++;
        if (hasUppercase) strength++;
        if (hasLowercase) strength++;
        if (hasNumber) strength++;
        if (hasSpecialChar) strength++;

        // Set tooltip content and style based on strength
        let tooltipMessage = '';
        let tooltipColor = '';
        if (strength === 0) {
            tooltipMessage = '';
            if (isTooltipVisible) {
                passwordTooltip.hide(); // Hide tooltip if no input
                isTooltipVisible = false;
            }
        } else if (strength <= 2) {
            tooltipMessage = 'Weak password. Include uppercase, lowercase, numbers, and special characters.';
            tooltipColor = 'red';
        } else if (strength <= 4) {
            tooltipMessage = 'Moderate password. Almost there!';
            tooltipColor = 'orange';
        } else {
            tooltipMessage = 'Strong password!';
            tooltipColor = 'green';
        }

        // Update tooltip content and style only if the message has changed
        if (passwordInput.getAttribute('data-bs-original-title') !== tooltipMessage) {
            passwordInput.setAttribute('data-bs-original-title', tooltipMessage);
            passwordTooltip.update(); // Update the tooltip content

            // Show the tooltip if it's not already visible
            if (!isTooltipVisible && tooltipMessage) {
                passwordTooltip.show();
                isTooltipVisible = true;
            }

            // Change tooltip color dynamically
            const tooltipInner = document.querySelector('.tooltip-inner');
            if (tooltipInner) {
                tooltipInner.style.backgroundColor = tooltipColor;
            }
        }
    });

    // Hide tooltip when input loses focus
    passwordInput.addEventListener('blur', function () {
        if (isTooltipVisible) {
            passwordTooltip.hide();
            isTooltipVisible = false;
        }
    });

    // Show tooltip when input gains focus (if there's content)
    passwordInput.addEventListener('focus', function () {
        if (passwordInput.value && !isTooltipVisible) {
            passwordTooltip.show();
            isTooltipVisible = true;
        }
    });
});
 document.addEventListener('DOMContentLoaded', function() {
    const mobileNoInput = document.getElementById('mobile_no');

    // Set initial value if empty
    if (!mobileNoInput.value) {
        mobileNoInput.value = '+639';
    }

    // Handle input events
    mobileNoInput.addEventListener('input', function(e) {
        let value = e.target.value;

        // Remove any non-numeric characters except +
        value = value.replace(/[^\d+]/g, '');

        // If completely empty, reset to +639
        if (value === '' || value === '+') {
            e.target.value = '+639';
            return;
        }

        // If backspacing before +639, reset to +639
        if (value.length < 4) {
            e.target.value = '+639';
            return;
        }

        // Ensure the +639 prefix
        if (!value.startsWith('+639')) {
            // Remove any existing +639 prefix
            value = value.replace(/^\+639/, '');
            
            // Remove any leading zeros or +
            value = value.replace(/^[0+]+/, '');

            // Add the +639 prefix
            value = '+639' + value;
        }

        // Limit the total length to 13 characters (+639 + 9 digits)
        if (value.length > 13) {
            value = value.slice(0, 13);
        }

        e.target.value = value;
    });

    // Handle focus event
    mobileNoInput.addEventListener('focus', function(e) {
        if (!e.target.value || e.target.value.length < 4) {
            e.target.value = '+639';
            // Place cursor at the end
            this.selectionStart = this.selectionEnd = this.value.length;
        }
    });

    // Handle blur (losing focus) event
    mobileNoInput.addEventListener('blur', function(e) {
        let value = e.target.value;
        
        // If only +639 is entered, it's considered empty
        if (value === '+639') {
            // You can either keep +639 or clear it based on your requirement
            e.target.value = '+639'; // or e.target.value = ''; if you want to clear it
        }
    });

    // Handle paste event
    mobileNoInput.addEventListener('paste', function(e) {
        e.preventDefault();
        let pastedText = (e.clipboardData || window.clipboardData).getData('text');
        
        // Remove all non-numeric characters
        pastedText = pastedText.replace(/\D/g, '');
        
        // Remove leading zeros
        pastedText = pastedText.replace(/^0+/, '');

        // Format the number
        if (pastedText) {
            // Take only up to 9 digits
            pastedText = pastedText.slice(-9);
            this.value = '+639' + pastedText;
        }
    });

    // Handle keydown event
    mobileNoInput.addEventListener('keydown', function(e) {
        const currentValue = this.value;
        const selectionStart = this.selectionStart;
        
        // Prevent deleting the +639 prefix
        if ((e.key === 'Backspace' || e.key === 'Delete') && 
            (currentValue.length <= 4 || 
             (selectionStart <= 4 && selectionStart >= 0))) {
            e.preventDefault();
            return;
        }

        // Allow: backspace, delete, tab, escape, enter, numbers
        if ([46, 8, 9, 27, 13, 110].indexOf(e.keyCode) !== -1 ||
            // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
            (e.keyCode === 65 && (e.ctrlKey || e.metaKey)) ||
            (e.keyCode === 67 && (e.ctrlKey || e.metaKey)) ||
            (e.keyCode === 86 && (e.ctrlKey || e.metaKey)) ||
            (e.keyCode === 88 && (e.ctrlKey || e.metaKey)) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39) ||
            // Allow: numbers
            ((e.keyCode >= 48 && e.keyCode <= 57) || 
             (e.keyCode >= 96 && e.keyCode <= 105))) {
            return;
        }

        // Block any other input
        e.preventDefault();
    });
});

document.querySelector('form').addEventListener('submit', function (e) {
    const password = document.getElementById('password').value;
    const feedback = document.getElementById('password-strength-feedback');

    // Define password strength rules
    const minLength = 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    // Check if all rules are met
    if (password.length < minLength || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecialChar) {
        e.preventDefault(); // Prevent form submission
        feedback.textContent = 'Password must be at least 8 characters long and include uppercase, lowercase, numbers, and special characters.';
        feedback.style.color = 'red';
    }
});
        // Toggle password visibility for the password field
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        togglePassword.addEventListener('click', function () {
            // Toggle the password visibility
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Change the icon opacity to indicate state
            if (type === 'password') {
                togglePasswordIcon.style.opacity = '0.5'; // Fully opaque when password is hidden
            } else {
                togglePasswordIcon.style.opacity = '1'; // Dimmed when password is visible
            }
        });

        // Toggle password visibility for the confirm password field
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const confirmPassword = document.getElementById('password_confirmation');
        const toggleConfirmPasswordIcon = document.getElementById('toggleConfirmPasswordIcon');

        toggleConfirmPassword.addEventListener('click', function () {
            // Toggle the confirm password visibility
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);

            // Change the icon opacity to indicate state
            if (type === 'password') {
                toggleConfirmPasswordIcon.style.opacity = '0.5'; // Fully opaque when password is hidden
            } else {
                toggleConfirmPasswordIcon.style.opacity = '1'; // Dimmed when password is visible
            }
        });

        // Format locality input
        document.getElementById('locality').addEventListener('blur', function (e) {
            let locality = e.target.value.trim();

            // Capitalize the first letter of each word
            locality = locality.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());

            // Append "City" if it doesn't already include it
            if (!locality.toLowerCase().includes('city')) {
                locality += ' City';
            }

            e.target.value = locality;
        });
    </script>
</body>

</html>