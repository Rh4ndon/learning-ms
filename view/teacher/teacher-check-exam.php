<!-- Session Check -->
<?php include '../../controllers/sessions.php'; ?>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <!-- Top Navbar -->
    <?php include 'top-navbar.php'; ?>

    <!-- Dashboard Content -->
    <div class="container-fluid animate__animated animate__fadeIn">
        <!-- Breadcrumb -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb pe-theme-breadcrumb">
                        <li class="breadcrumb-item"><a href="teacher-dashboard.php" class="pe-theme-link">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="teacher-exam-submission.php" class="pe-theme-link">Exam Submissions</a></li>
                        <li class="breadcrumb-item active">Check Exam</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Exams Table -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card pe-theme-card">
                    <?php include '../../controllers/get-student-answer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for confirmation -->

    <div class="modal fade" id="submitConfirmationModal" tabindex="-1" aria-labelledby="submitConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitConfirmationModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to submit student's Grade? You cannot change them after submission.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmSubmit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get the form element
            const form = document.getElementById('gradeForm');
            const modal = new bootstrap.Modal('#submitConfirmationModal');

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                modal.show();
            });

            document.getElementById('confirmSubmit').addEventListener('click', () => {
                form.submit();
            });

            // Add Excel download functionality
            document.getElementById('downloadExcel')?.addEventListener('click', function() {
                const table = document.getElementById('exam');
                const rows = table.querySelectorAll('tr');
                let csvContent = "data:text/csv;charset=utf-8,";

                // Add headers
                const headers = ["Question", "Type", "Points", "Options", "Correct Answer", "Points Earned"];
                csvContent += headers.join(",") + "\r\n";

                // Process each data row
                rows.forEach((row, index) => {
                    // Skip header row and total row (we'll handle it separately)
                    if (index === 0 || row.classList.contains('table-secondary')) return;

                    const cells = row.querySelectorAll('td');
                    let rowData = [];

                    // Question (column 1)
                    rowData.push(`"${cells[0].textContent.trim().replace(/"/g, '""')}"`);

                    // Type (column 2)
                    rowData.push(`"${cells[1].textContent.trim()}"`);

                    // Points (column 3)
                    rowData.push(cells[2].textContent.trim());

                    // Options (column 4) - format all options with selected marked
                    const optionsCell = cells[3];
                    const options = [];
                    const optionElements = optionsCell.querySelectorAll('.form-check-label');
                    const selectedOption = optionsCell.querySelector('input[type="radio"]:checked')?.nextElementSibling?.textContent.trim();

                    optionElements.forEach(option => {
                        const optionText = option.textContent.trim();
                        const isSelected = optionText === selectedOption;
                        options.push(`${isSelected ? '✅ ' : ''}${optionText}`);
                    });

                    rowData.push(`"${options.join('\\n')}"`); // Use \n for line breaks in Excel

                    // Correct Answer (column 5) - get the correct option
                    const correctAnswerCell = cells[4];
                    const correctOption = correctAnswerCell.querySelector('input[type="radio"]:checked')?.nextElementSibling?.textContent.trim();
                    rowData.push(`"${correctOption || ''}"`);

                    // Points Earned (column 6)
                    const pointsCell = cells[5];
                    const pointsInput = pointsCell.querySelector('input[type="number"]');
                    rowData.push(pointsInput ? `${pointsInput.value}/${questions['points']}` : pointsCell.textContent.trim());

                    // Add row to CSV content
                    csvContent += rowData.join(",") + "\r\n";
                });

                // Add total points row
                const totalRow = table.querySelector('.table-secondary');
                if (totalRow) {
                    const totalCells = totalRow.querySelectorAll('td');
                    csvContent += `"Total Points Earned:",,,,,"${totalCells[5].textContent.trim()}"\r\n`;
                }

                // Create download link
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);

                // Set filename
                const examTitle = '<?php echo $exam["title"]; ?>';
                const studentName = '<?php echo $student["first_name"] . "_" . $student["last_name"]; ?>';
                link.setAttribute("download", `${examTitle}_${studentName}_Results.csv`);

                // Trigger download
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);


            });
            document.getElementById('printExam')?.addEventListener('click', function() {
                //Print page
                window.print();
            });
        });
    </script>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>