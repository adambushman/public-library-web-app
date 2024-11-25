<?php
echo <<<_END
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    </script>
    <footer class="mt-auto text-bg-light">
        <div class="container my-3">
            <div class="row justify-content-center">
                <div class="col-12 d-inline-flex justify-content-center align-items-center">
                    <p class="m-0">
                        <i class="bi bi-book-fill me-2"></i>
                        Public Library | Copyright &copy 2024
                    </p>
                </div>
            </div>
        </div>
    </footer>
    </body>
</html>
_END;