<aside id="sidebar" class="expand" style="background: linear-gradient(135deg, #0b0e1f, #0040ff); color: #000; padding: 1rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); overflow: hidden; width: 260px; transition: width 0.5s ease; position: fixed; top: 0; left: 0; height: 100vh; z-index: 1000;">
    <div class="d-flex align-items-center mb-3" style="margin-left: 0;">
        <div class="sidebar-logo ms-1 text-center" style="width: 100%; overflow: hidden;">
            <img src="{{ asset('assets/Travel.png') }}" alt="TravelMate Logo" style="width: 120px; margin-bottom: 10px;">
            <h3 style="font-weight: bold; color: #fff; font-size: 2rem; text-align: center; white-space: nowrap; font-family: 'Poppins', sans-serif;">TRAVELMATE</h3>
        </div>
    </div>
    <div class="usertype text-center mb-4" style="font-size: 2rem; padding-top: 10px;">
        <h5 style="font-weight: 800; font-size: 1.5rem; color: #ffffff; font-family: 'Poppins', sans-serif;">        {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}

        <h5 style="font-weight: 600; color: #fff; font-size: 1.8rem; font-family: 'Poppins', sans-serif;">SUPER</h5>
    </div>
    <ul class="sidebar-nav list-unstyled">
        <li class="sidebar-item mb-3">
            <div class="sidebar-item-wrapper" style="background-color: #ffffff; border-radius: 5px;">
                <a href="/super/dashboard" class="sidebar-link d-flex align-items-center justify-content-center" style="text-decoration: none; padding: 10px 15px; background-color: #ffffff; color: #000; border-radius: 5px; transition: background 0.3s ease;">
                    <i class="lni lni-agenda me-3" style="font-size: 1.5rem; color: #000;"></i>
                    <span style="font-size: 1.1rem; color: #000; font-family: 'Poppins', sans-serif;">Dashboard</span>
                </a>
            </div>
        </li>
        <li class="sidebar-item mb-3">
            <div class="sidebar-item-wrapper" style="background-color: #ffffff; border-radius: 5px;">
                <a href="/super/admins/create" class="sidebar-link d-flex align-items-center justify-content-center" style="text-decoration: none; padding: 10px 15px; background-color: #ffffff; color: #000; border-radius: 5px; transition: background 0.3s ease;">
                    <i class="lni lni-user me-3" style="font-size: 1.5rem; color: #000;"></i>
                    <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Add Admin</span>
                </a>
            </div>
        </li>
        <li class="sidebar-item mb-3">
            <div class="sidebar-item-wrapper" style="background-color: #ffffff; border-radius: 5px;">
                <a href="/super/admins" class="sidebar-link d-flex align-items-center justify-content-center" style="text-decoration: none; padding: 10px 15px; background-color: #ffffff; color: #000; border-radius: 5px; transition: background 0.3s ease;">
                    <i class="lni lni-users me-3" style="font-size: 1.5rem; color: #000;"></i>
                    <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">View Admins</span>
                </a>
            </div>
        </li>
    </ul>
    <div class="sidebar-footer mt-5">
        <div class="sidebar-item-wrapper" style="background-color: #ffffff; border-radius: 5px;">
            <a href="/logout" class="sidebar-link d-flex align-items-center justify-content-center" style="text-decoration: none; padding: 10px 15px; background-color: #ffffff; color: #000; border-radius: 5px; transition: background 0.3s ease;">
                <i class="lni lni-exit me-3" style="font-size: 1.5rem; color: #000;"></i>
                <span style="font-size: 1.1rem; font-family: 'Poppins', sans-serif;">Logout</span>
            </a>
        </div>
    </div>
</aside>

<!-- Include Google Font Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    /* Sidebar Styles */
    #sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 260px;
        background: linear-gradient(135deg, #0b0e1f, #0040ff);
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
        color: #000;
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .sidebar-logo, .usertype {
        transition: opacity 0.5s ease;
    }

    #sidebar:not(.expand) .sidebar-logo, #sidebar:not(.expand) .usertype {
        opacity: 0;
    }

    /* Icon and text visibility handling for collapsed sidebar */
    #sidebar.expand .sidebar-link span {
        display: inline;
    }
    #sidebar:not(.expand) .sidebar-link span {
        display: none;
    }
    #sidebar:not(.expand) .sidebar-link {
        justify-content: center;
    }

    /* Adjust main content margin to account for the sidebar */
    .main {
        margin-left: 260px; /* Matches the sidebar width */
        transition: margin-left 0.5s ease;
    }

    @media (max-width: 768px) {
        #sidebar {
            width: 80px;
        }

        #sidebar.expand {
            width: 260px;
        }

        .main {
            margin-left: 80px;
        }
    }

    /* Hover animation for sidebar items */
    .sidebar-item-wrapper:hover {
        transition: all 0.3s ease;
        transform: translateX(5px);
    }

    /* Sidebar dropdown animation */
    .sidebar-dropdown {
        transition: max-height 0.5s ease;
    }
</style>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('expand');
    }
</script>