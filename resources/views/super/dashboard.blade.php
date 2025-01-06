<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('assets/Travel.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <style>
        :root {
            --primary-blue: #0040ff;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, #0b0e1f, var(--primary-blue));
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .main {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .welcome-banner {
            background: var(--primary-blue);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 1rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
        }

        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-title {
            font-size: 1.1rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.75rem;
        }

        .stat-value {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.active {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        @include('super/partials/aside')
        <div class="main">
            <div class="welcome-banner">
                <h1 class="m-0" style="font-size: 1.75rem; font-weight: 600;">
                    Dashboard
                </h1>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Admins</div>
                    <div class="stat-value">{{ $adminCount }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">Owners</div>
                    <div class="stat-value">{{ $ownerCount }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">Destinations</div>
                    <div class="stat-value">{{ $destinationCount }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-title">Reviews</div>
                    <div class="stat-value">{{ $reviewCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.sidebar-toggle');
            const sidebar = document.getElementById('sidebar');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('active');
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(e.target) && !toggleBtn?.contains(e.target)) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>