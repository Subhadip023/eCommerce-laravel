import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
const successMsg = document.getElementById('successMsg');

if (successMsg) {
    setTimeout(() => {
        successMsg.style.display = 'none';
    }, 3000);
}
