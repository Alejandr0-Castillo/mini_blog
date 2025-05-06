document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newPostForm');
    const postsSection = document.getElementById('posts');
    const tituloInput = document.getElementById('titulo');
    const contenidoInput = document.getElementById('contenido');

    const btnCrearPost = document.getElementById('btnCrearPost');
    const btnCancelar = document.getElementById('btnCancelar');
    const seccionPosts = document.getElementById('seccionPosts');
    const seccionCrear = document.getElementById('seccionCrear');

    // Mostrar formulario y ocultar publicaciones
    btnCrearPost.addEventListener('click', function() {
        seccionPosts.style.display = 'none';
        seccionCrear.style.display = 'block';
    });

    // Cancelar y volver a publicaciones
    btnCancelar.addEventListener('click', function() {
        seccionCrear.style.display = 'none';
        seccionPosts.style.display = 'block';
    });

    // Envío del formulario con AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const titulo = tituloInput.value.trim();
        const contenido = contenidoInput.value.trim();

        if (titulo && contenido) {
            const formData = new FormData();
            formData.append('titulo', titulo);
            formData.append('contenido', contenido);

            fetch('publicar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.id) {
                    const post = document.createElement('article');
                    const postTitle = document.createElement('h2');
                    postTitle.textContent = titulo;
                    const postContent = document.createElement('p');
                    postContent.textContent = contenido;
                    const deleteLink = document.createElement('a');
                    deleteLink.href = `index.php?eliminar=${data.id}`;
                    deleteLink.textContent = 'Borrar';

                    post.appendChild(postTitle);
                    post.appendChild(postContent);
                    post.appendChild(deleteLink);

                    postsSection.insertBefore(post, postsSection.firstChild);

                    tituloInput.value = '';
                    contenidoInput.value = '';

                    // Ocultar el formulario y volver a las publicaciones
                    seccionCrear.style.display = 'none';
                    seccionPosts.style.display = 'block';
                } else {
                    alert('Error al crear la publicación: ' + (data.message || 'Error desconocido.'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error de red o del servidor.');
            });
        } else {
            alert('Por favor, complete todos los campos.');
        }
    });
});