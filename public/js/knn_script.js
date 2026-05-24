document.addEventListener('DOMContentLoaded', () => {
    // UI Elements
    const kSlider = document.getElementById('kSlider');
    const kValue = document.getElementById('kValue');
    const uploadZone = document.getElementById('uploadZone');
    const uploadStatus = document.getElementById('uploadStatus');
    const fileInput = document.getElementById('excelFile');
    const predictBtn = document.getElementById('predictBtn');
    const resultPanel = document.getElementById('resultPanel');
    const predResult = document.getElementById('predResult');
    const neighborsTableBody = document.querySelector('#neighborsTable tbody');
    const dashTotalData = document.getElementById('dashTotalData');
    const dashKValue = document.getElementById('dashKValue');
    const pageTitle = document.getElementById('pageTitle');

    // Sidebar Navigation Logic
    const navItems = document.querySelectorAll('.nav-item[data-target]');
    const viewSections = document.querySelectorAll('.view-section');

    navItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove active from all nav items
            document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
            item.classList.add('active');

            // Hide all views
            viewSections.forEach(view => {
                view.classList.remove('active');
            });

            // Show target view
            const targetView = document.getElementById('view-' + item.dataset.target);
            if(targetView) {
                targetView.classList.add('active');
            }
            
            // Update Header
            pageTitle.textContent = item.textContent.trim();
        });
    });

    let trainingData = [];
    let predictionHistory = [];

    // Slider Updates
    kSlider.addEventListener('input', (e) => {
        kValue.textContent = e.target.value;
        dashKValue.textContent = e.target.value;
    });

    // File Upload Handler
    fileInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (evt) => {
            try {
                const data = new Uint8Array(evt.target.result);
                const workbook = XLSX.read(data, {type: 'array'});
                const firstSheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[firstSheetName];
                
                // Parse to 2D array, header: 1 gives array of arrays
                const rawData = XLSX.utils.sheet_to_json(worksheet, {header: 1});
                
                trainingData = [];
                // Data usually starts at index 2 (row 3) because of merged headers in this specific template
                for (let i = 2; i < rawData.length; i++) {
                    const row = rawData[i];
                    // Basic validation: skip empty rows or rows without Nama (index 3) and Ekskul (index 22)
                    if (!row || row.length < 23 || !row[3] || !row[22]) continue; 
                    
                    // Sesuai dengan perhitungan manual, hanya 4 fitur: MTK(12), IPA(13), PJOK(15), SBP(18)
                    const scores = [
                        row[12], // MTK
                        row[13], // IPA
                        row[15], // PJOK
                        row[18]  // SBP
                    ].map(v => parseFloat(v) || 0);

                    trainingData.push({
                        name: row[3],
                        scores: scores,
                        rank: parseFloat(row[21]) || 999,
                        ekskul: String(row[22]).trim()
                    });
                }

                if (trainingData.length > 0) {
                    uploadStatus.style.display = 'block';
                    uploadStatus.innerHTML = `<i class="fa-solid fa-check-circle"></i> Berhasil memuat ${trainingData.length} baris data latih!`;
                    uploadZone.style.borderColor = 'var(--success)';
                    uploadZone.style.background = 'rgba(16, 185, 129, 0.1)';
                    uploadZone.querySelector('.upload-icon').classList.remove('pulse-icon');
                    dashTotalData.textContent = trainingData.length;
                } else {
                    alert('Gagal membaca data dari Excel. Pastikan format kolom sesuai dengan template gambar.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan saat membaca file Excel.');
            }
        };
        reader.readAsArrayBuffer(file);
    });

    // Euclidean Distance Function
    function calculateEuclideanDistance(arr1, arr2) {
        let sum = 0;
        for(let i = 0; i < 4; i++) { // Menggunakan 4 kriteria
            sum += Math.pow((arr1[i] || 0) - (arr2[i] || 0), 2);
        }
        return Math.sqrt(sum);
    }

    // Predict Function
    predictBtn.addEventListener('click', () => {
        if (trainingData.length === 0) {
            alert('Harap unggah Data Excel terlebih dahulu!');
            return;
        }

        // Get inputs
        const inputs = document.querySelectorAll('.score-input');
        let allFilled = true;
        const newScores = [];
        
        inputs.forEach(input => {
            if (input.value === '') {
                allFilled = false;
            }
            newScores.push(parseFloat(input.value) || 0);
        });

        if (!allFilled) {
            alert('Mohon isi ke-4 nilai mata pelajaran siswa terlebih dahulu.');
            return;
        }

        // Processing State
        const originalText = predictBtn.innerHTML;
        predictBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menghitung Algoritma KNN...';
        predictBtn.disabled = true;
        resultPanel.classList.remove('active');

        setTimeout(() => {
            predictBtn.innerHTML = originalText;
            predictBtn.disabled = false;

            // 1. MENGGUNAKAN SEMUA DATA (Tanpa Filter N) seperti perhitungan manual
            const topNData = [...trainingData];

            // 2. HITUNG JARAK
            const distances = topNData.map(student => {
                return {
                    ...student,
                    distance: calculateEuclideanDistance(newScores, student.scores)
                };
            });

            // 3. AMBIL K TERDEKAT (Jarak terkecil)
            const k = parseInt(kValue.textContent);
            // Sort ascending berdasarkan jarak
            const topKNeighbors = distances.sort((a, b) => a.distance - b.distance).slice(0, k);

            // 4. VOTING MAYORITAS & TIE-BREAKER
            const counts = {};
            topKNeighbors.forEach(neighbor => {
                counts[neighbor.ekskul] = (counts[neighbor.ekskul] || 0) + 1;
            });

            let predictedEkskul = '';
            let maxCount = 0;

            for (let ekskul in counts) {
                if (counts[ekskul] > maxCount) {
                    maxCount = counts[ekskul];
                    predictedEkskul = ekskul;
                } else if (counts[ekskul] === maxCount) {
                    // TIE-BREAK: Jika ada seri, pilih Ekskul yang dimiliki oleh siswa dengan Rank tertinggi di antara mereka
                    const neighborA = topKNeighbors.find(n => n.ekskul === predictedEkskul);
                    const neighborB = topKNeighbors.find(n => n.ekskul === ekskul);
                    
                    if (neighborB && neighborA && neighborB.rank < neighborA.rank) {
                        predictedEkskul = ekskul;
                    }
                }
            }

            // 5. UPDATE UI
            predResult.textContent = predictedEkskul || 'Tidak Diketahui';
            
            // Populate Table
            neighborsTableBody.innerHTML = '';
            topKNeighbors.forEach((neighbor, index) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${index + 1}. ${neighbor.name}</td>
                    <td>Rank ${neighbor.rank}</td>
                    <td>${neighbor.distance.toFixed(2)}</td>
                    <td style="font-weight: 600; color: ${neighbor.ekskul === predictedEkskul ? 'var(--success)' : 'var(--text-main)'}">${neighbor.ekskul}</td>
                `;
                neighborsTableBody.appendChild(tr);
            });

            resultPanel.classList.add('active');

            // SIMPAN KE RIWAYAT
            const now = new Date();
            const timeString = now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + ' - ' + now.toLocaleDateString();
            
            predictionHistory.unshift({
                time: timeString,
                scores: newScores,
                kValue: k,
                result: predictedEkskul
            });
            
            updateHistoryUI();

        }, 800); // 800ms delay for visual effect
    });

    function updateHistoryUI() {
        const emptyRiwayat = document.getElementById('emptyRiwayat');
        const tableRiwayatContainer = document.getElementById('tableRiwayatContainer');
        const historyTableBody = document.querySelector('#historyTable tbody');
        
        if(predictionHistory.length === 0) return;
        
        emptyRiwayat.style.display = 'none';
        tableRiwayatContainer.style.display = 'block';
        
        historyTableBody.innerHTML = '';
        predictionHistory.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.time}</td>
                <td style="letter-spacing: 1px;">[${item.scores.join(', ')}]</td>
                <td>K=${item.kValue}</td>
                <td style="font-weight: 600; color: var(--success);">${item.result}</td>
            `;
            historyTableBody.appendChild(tr);
        });
    }
});
