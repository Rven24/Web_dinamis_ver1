    <?php include 'includes/header.php'; ?>
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';
    $pagePath = 'content/' . $page . '.php';
    if (file_exists($pagePath)) {
    include $pagePath;
    } else {
    echo "<h1>404 - Page Not Found</h1>";
    }
    ?>
    </main>
    </div>
    <section style="padding: 20px; text-align: center;">
    <h3>Terima Kasih Sudah Berkunjung</h3>
    <p>Jangan lupa follow sosial media saya yah</p>
    </section>
    <footer>
    <p>&copy; Copyright by Website Rvenn 2024</p>
    </footer>
    <script>
    document.addEventListener('DOMContentLoaded', (event) => {
    const container = document.querySelector('.container');
    const navLinks = document.querySelectorAll('nav ul li a');

    // Set active nav item based on current URL
    function setActiveNavItem() {
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    }

    setActiveNavItem();

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const target = e.target.href;

            // Remove active class from all links
            navLinks.forEach(navLink => {
                navLink.classList.remove('active');
                navLink.classList.add('faded');
            });

            // Add active class to clicked link
            e.target.classList.add('active');
            e.target.classList.remove('faded');

            container.classList.add('fade-out');

            setTimeout(() => {
                window.location.href = target;
            }, 1000); // Match this with your transition time
        });
    });

    // Fade in container on page load
    container.classList.add('fade-out');
    setTimeout(() => {
        container.classList.remove('fade-out');
        container.classList.add('fade-in');
    }, 100);
    });
    </script>
    </body>

</html>