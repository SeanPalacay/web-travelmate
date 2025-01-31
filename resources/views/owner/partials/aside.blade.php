<aside id="sidebar" class="expand" style="background: linear-gradient(180deg, #0b0e1f, #0040ff); color: #000; padding: 1rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); overflow: hidden; width: 260px; transition: width 0.5s ease; position: fixed; top: 0; left: 0; height: 100vh; display: flex; flex-direction: column;">
    <div>
        <div class="d-flex align-items-center mb-3" style="margin-left: 0;">
            <div class="sidebar-logo ms-1 text-center" style="width: 100%; overflow: hidden;">
                <img src="{{ asset('assets/Travel.png') }}" alt="TravelMate Logo" style="width: 120px; margin-bottom: 10px;">
                <h3 style="font-weight: bold; color: #ffffff; font-size: 2rem; text-align: center; white-space: nowrap; font-family: 'Poppins', sans-serif;">TRAVELMATE</h3>
            </div>
        </div>
        <div class="usertype text-center mb-4" style="font-size: 2rem; padding-top: 10px;">
            <h5 style="font-weight: 800; font-size: 1.5rem; color: #ffffff; font-family: 'Poppins', sans-serif;">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</h5>
            <h3 style="font-weight: 300; color: #ffffff; font-size: 1rem; font-family: 'Poppins', sans-serif;">Owner</h3>
        </div>

        <ul class="sidebar-nav list-unstyled">
            <!-- Dashboard -->
            <li class="sidebar-item mb-3">
                <div class="sidebar-item-wrapper d-flex align-items-center" style="background-color: #ffffff; border-radius: 5px; padding: 10px;">
                    <a href="/owner/dashboard" class="sidebar-link d-flex align-items-center w-100" style="text-decoration: none; color: #000;">
                        <i class="lni lni-agenda me-3" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Dashboard</span>
                    </a>
                </div>
            </li>

            <!-- Reviews -->
            <li class="sidebar-item mb-3">
                <div class="sidebar-item-wrapper d-flex align-items-center" style="background-color: #ffffff; border-radius: 5px; padding: 10px;">
                    <a href="/owner/reviews" class="sidebar-link d-flex align-items-center w-100" style="text-decoration: none; color: #000;">
                        <i class="lni lni-pencil me-3" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Reviews</span>
                    </a>
                </div>
            </li>

            <!-- Application Dropdown -->
            <li class="sidebar-item mb-3">
                <div class="sidebar-item-wrapper d-flex align-items-center" style="background-color: #ffffff; border-radius: 5px; padding: 10px;">
                    <a href="#" class="sidebar-link d-flex align-items-center w-100 collapsed" style="text-decoration: none; color: #000;" data-bs-toggle="collapse" data-bs-target="#application" aria-expanded="false" aria-controls="application">
                        <i class="lni lni-briefcase me-3" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Application</span>
                    </a>
                </div>
                <ul id="application" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar" style="background-color: #e0e0e0; border-radius: 5px;">
                    <li class="sidebar-item">
                        <a href="/owner/applications/create" class="sidebar-link" style="text-decoration: none; color: #000; padding: 5px 15px;">
                            <span style="font-size: 1rem; font-family: 'Poppins', sans-serif;">Create Application</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="/owner/applications" class="sidebar-link" style="text-decoration: none; color: #000; padding: 5px 15px;">
                            <span style="font-size: 1rem; font-family: 'Poppins', sans-serif;">My Applications</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Destinations -->
            <li class="sidebar-item mb-3">
                <div class="sidebar-item-wrapper d-flex align-items-center" style="background-color: #ffffff; border-radius: 5px; padding: 10px;">
                    <a href="/owner/destinations" class="sidebar-link d-flex align-items-center w-100" style="text-decoration: none; color: #000;">
                        <i class="lni lni-car me-3" style="font-size: 1.5rem;"></i>
                        <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Destinations</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>

    <!-- Logout Button -->
    <div class="sidebar-footer" style="margin-top: auto;">
        <div class="sidebar-item-wrapper d-flex align-items-center" style="background-color: #ffffff; border-radius: 5px;">
            <a href="/logout" class="sidebar-link d-flex align-items-center w-100 justify-content-center" style="text-decoration: none; padding: 10px 15px; background-color: #ffffff; color: #000; border-radius: 5px;">
                <i class="lni lni-exit me-3" style="font-size: 1.5rem;"></i>
                <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Logout</span>
            </a>
        </div>
    </div>
</aside>

<!-- Include Google Font Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* Ensure the body has a left margin equal to the sidebar width */
    .main {
        margin-left: 260px; /* Matches the sidebar width */
        transition: margin-left 0.5s ease;
    }

    /* Adjust for smaller screens */
    @media (max-width: 768px) {
        body {
            margin-left: 80px; /* Matches the collapsed sidebar width */
        }
    }

    /* Sidebar Styles */
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        background: linear-gradient(180deg, #0b0e1f, #0040ff);
        color: #000;
        padding: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto; /* Allow scrolling within the sidebar if content overflows */
        transition: width 0.5s ease;
        z-index: 1000; /* Ensure sidebar is above other content */
    }

    #sidebar.expand {
        width: 260px;
    }

    #sidebar:not(.expand) {
        width: 80px;
    }

    .sidebar-link:hover {
        background-color: rgba(0, 0, 0, 0.1);
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('expand');
    }
</script>