/*este código permiti que as abas sejam abertas*/

document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-tab');
    const contents = document.querySelectorAll('.content');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));
            
            this.classList.add('active');
            const contentId = this.getAttribute('data-tab');
            document.getElementById(contentId).classList.add('active');
        });
    });

    document.querySelector('.nav-tab[data-tab="exames"]').click();

    function toggleProfileForm() {
        const profileForm = document.getElementById('profileForm');
        
        if (profileForm.style.display === 'none' || profileForm.style.display === '') {
            profileForm.style.display = 'block';
        } else {
            profileForm.style.display = 'none';
        }
    };});

