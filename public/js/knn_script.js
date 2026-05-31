document.addEventListener('DOMContentLoaded', () => {
    const kSlider = document.getElementById('kSlider');
    const kValue = document.getElementById('kValue');
    const dashKValue = document.getElementById('dashKValue');
    const pageTitle = document.getElementById('pageTitle');
    const trainingFile = document.getElementById('trainingFile');
    const selectedFileName = document.getElementById('selectedFileName');
    const calculationModal = document.getElementById('calculationModal');
    const navItems = document.querySelectorAll('.nav-item[data-target]');
    const viewSections = document.querySelectorAll('.view-section');

    navItems.forEach((item) => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.nav-item').forEach((nav) => nav.classList.remove('active'));
            item.classList.add('active');

            viewSections.forEach((view) => view.classList.remove('active'));

            const targetView = document.getElementById('view-' + item.dataset.target);
            if (targetView) {
                targetView.classList.add('active');
            }

            pageTitle.textContent = item.textContent.trim();
        });
    });

    if (kSlider) {
        kSlider.addEventListener('input', (event) => {
            kValue.textContent = event.target.value;
            dashKValue.textContent = event.target.value;
        });
    }

    if (trainingFile && selectedFileName) {
        trainingFile.addEventListener('change', () => {
            selectedFileName.textContent = trainingFile.files[0]?.name || 'Belum ada file dipilih';
        });
    }

    if (calculationModal) {
        document.querySelectorAll('[data-close-modal]').forEach((button) => {
            button.addEventListener('click', () => calculationModal.classList.remove('active'));
        });

        calculationModal.addEventListener('click', (event) => {
            if (event.target === calculationModal) {
                calculationModal.classList.remove('active');
            }
        });
    }
});
