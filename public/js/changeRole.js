const buttons = document.querySelectorAll('.role');

buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const role = btn.dataset.role;

        fetch(`/admin/users/edit/${id}/${role}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                //alert(data.role);
                if (data.role === "ROLE_ADMIN") {
                    document.querySelector(`#roles_${id}`).innerText = "ADMIN";
                    document.querySelector(`#rolesAdmin_${id}`).classList.add('admin');
                    document.querySelector(`#rolesAdmin_${id}`).classList.remove('userColor');
                }else if (data.role === "ROLE_USER"){
                    document.querySelector(`#roles_${id}`).innerText = "USER";
                    document.querySelector(`#rolesAdmin_${id}`).classList.add('userColor');
                    document.querySelector(`#rolesAdmin_${id}`).classList.remove('admin');
                }
            })
            .catch(error => alert(error))
    })
});