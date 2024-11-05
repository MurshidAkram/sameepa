// app/public/js/visitor_passes.js

document.addEventListener('DOMContentLoaded', function() {
    const visitorPassForm = document.getElementById('visitorPassForm');
    const passList = document.getElementById('passList');
    const editModal = document.getElementById('editModal');
    const editForm = document.getElementById('editForm');
    const closeBtn = document.getElementsByClassName('close')[0];

    let passes = JSON.parse(localStorage.getItem('visitorPasses')) || [];

    function renderPasses() {
        passList.innerHTML = '';
        passes.forEach((pass, index) => {
            const passCard = document.createElement('div');
            passCard.classList.add('pass-card');
            passCard.innerHTML = `
                <h3>Visitor: ${pass.visitorName}</h3>
                <div class="pass-details">
                    <p><strong>Number of Visitors:</strong> ${pass.visitorCount}</p>
                    <p><strong>Visit Date:</strong> ${pass.visitDate}</p>
                    <p><strong>Visit Time:</strong> ${pass.visitTime}</p>
                    <p><strong>Duration:</strong> ${pass.duration} hours</p>
                    <p><strong>Purpose:</strong> ${pass.purpose}</p>
                </div>
                <div class="pass-actions">
                    <button class="btn-edit" data-id="${index}">Edit</button>
                    <button class="btn-delete" data-id="${index}">Delete</button>
                </div>
            `;
            passList.appendChild(passCard);
        });

        // Add event listeners to edit and delete buttons
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', editPass);
        });
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', deletePass);
        });
    }

    visitorPassForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(visitorPassForm);
        const newPass = {
            visitorName: formData.get('visitorName'),
            visitorCount: formData.get('visitorCount'),
            visitDate: formData.get('visitDate'),
            visitTime: formData.get('visitTime'),
            duration: formData.get('duration'),
            purpose: formData.get('purpose')
        };
        passes.push(newPass);
        localStorage.setItem('visitorPasses', JSON.stringify(passes));
        renderPasses();
        visitorPassForm.reset();
    });

    function editPass(e) {
        const id = e.target.getAttribute('data-id');
        const pass = passes[id];
        document.getElementById('editId').value = id;
        document.getElementById('editVisitorName').value = pass.visitorName;
        document.getElementById('editVisitorCount').value = pass.visitorCount;
        document.getElementById('editVisitDate').value = pass.visitDate;
        document.getElementById('editVisitTime').value = pass.visitTime;
        document.getElementById('editDuration').value = pass.duration;
        document.getElementById('editPurpose').value = pass.purpose;
        editModal.style.display = 'block';
    }

    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editId').value;
        passes[id] = {
            visitorName: document.getElementById('editVisitorName').value,
            visitorCount: document.getElementById('editVisitorCount').value,
            visitDate: document.getElementById('editVisitDate').value,
            visitTime: document.getElementById('editVisitTime').value,
            duration: document.getElementById('editDuration').value,
            purpose: document.getElementById('editPurpose').value
        };
        localStorage.setItem('visitorPasses', JSON.stringify(passes));
        renderPasses();
        editModal.style.display = 'none';
    });

    function deletePass(e) {
        const id = e.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this visitor pass?')) {
            passes.splice(id, 1);
            localStorage.setItem('visitorPasses', JSON.stringify(passes));
            renderPasses();
        }
    }

    closeBtn.onclick = function() {
        editModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == editModal) {
            editModal.style.display = 'none';
        }
    }

    renderPasses();
});