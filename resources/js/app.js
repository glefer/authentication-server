import './bootstrap';

import Alpine from 'alpinejs';

import Swal from 'sweetalert2'

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll('.delete-form').forEach(el => {
        el.addEventListener('submit',
            (evt) => {
                var form = evt.target;
                evt.preventDefault()
                Swal.fire({
                    title: 'Delete a record',
                    text: 'Do you want to continue ?',
                    icon: 'question',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
            }
        )
    }
);

