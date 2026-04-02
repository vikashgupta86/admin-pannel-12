document.addEventListener("DOMContentLoaded", function () {

    const modal = document.getElementById('editorModal');

    if (!modal) return;

    modal.addEventListener('shown.bs.modal', function () {

        if (tinymce.get('editor')) return;


        tinymce.init({
        selector: '#textarea2',
        license_key: 'gpl',
        height: 500,
        menubar: 'insert format table',
        plugins: [
            'advlist', 'lists', 'link', 'image', 
            'anchor', 'searchreplace',
            'table'
        ],


        toolbar: 'undo redo | ' +
            'bold italic underline | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'image table link',
        
        images_upload_url: 'upload_image.php',
        automatic_uploads: true,
        skin: 'oxide',
        content_css: 'default',
        
        image_dimensions: false,
        image_description: false,
        image_class_list: [
            {title: 'Responsive Image', value: 'img-fluid w-100 h-auto'}
        ],
        
        skin: 'oxide',
        content_css: 'default',
        
        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'upload_image.php');

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status < 200 || xhr.status >= 300) {
                    reject('HTTP Error: ' + xhr.status);
                    return;
                }

                const json = JSON.parse(xhr.responseText);

                if (!json || typeof json.location != 'string') {
                    reject('Invalid JSON: ' + xhr.responseText);
                    return;
                }

                resolve(json.location);
            };

            xhr.onerror = () => {
                reject('Image upload failed due to a network error.');
            };

            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            
            formData.append('__csrf_magic', 'sid:6ea8ccaafb21ac127432f62d6cff19a6c6fa3835,1772756707');

            xhr.send(formData);
        }),

        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px; color: #1e293b; background-color: #fff; padding: 20px; } ' +
                      'img { max-width: 100%; height: auto; display: block; margin: 10px 0; }',
        
        setup: (editor) => {
            editor.on('OpenWindow', (e) => {
                setTimeout(() => {
                    const dialog = document.querySelector('.tox-dialog');
                    if (dialog && /insert\/edit image/i.test(dialog.innerText)) {
                        const uploadTab = Array.from(document.querySelectorAll('.tox-dialog__body-nav-item'))
                            .find(el => el.innerText.includes('Upload'));
                        if (uploadTab) uploadTab.click();
                    }
                }, 50);
            });
        }
    });

    document.getElementById('save-btn').addEventListener('click', function() {
        const titleInput = document.getElementById('post-title');
        const editor = tinymce.get('editor');
        const btn = this;
        const statusDiv = document.getElementById('status-message');
        
        const title = titleInput.value;
        const content = editor.getContent();

        if (!content.trim()) {
            showStatus('Please enter some content before saving.', 'error');
            return;
        }

        btn.disabled = true;
        titleInput.disabled = true;
        editor.mode.set('readonly');
        
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="loading-spinner"></span> Saving Content...';

        const formData = new FormData();
        const editId = document.getElementById('edit-id').value;
        if (editId > 0) {
            formData.append('id', editId);
        }
        formData.append('title', title);
        formData.append('content', content);
        
        formData.append('__csrf_magic', 'sid:6ea8ccaafb21ac127432f62d6cff19a6c6fa3835,1772756707');

        fetch('save_content.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showStatus(data.message, 'success');
                
                setTimeout(() => {
                    const modalElement = document.getElementById('editorModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    
                    setTimeout(() => {
                        titleInput.value = '';
                        editor.setContent('');
                        titleInput.disabled = false;
                        editor.mode.set('design');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        statusDiv.style.display = 'none';
                    }, 500); 
                }, 5000);

            } else {
                showStatus(data.message, 'error');
                reEnableFields();
            }
        })
        .catch(error => {
            showStatus('An error occurred: ' + error.message, 'error');
            reEnableFields();
        });

        function reEnableFields() {
            btn.disabled = false;
            titleInput.disabled = false;
            editor.mode.set('design');
            btn.innerHTML = originalText;
        }
    });


    function showStatus(message, type) {
        const statusDiv = document.getElementById('status-message');
        statusDiv.innerText = message;
        statusDiv.className = type === 'success' ? 'status-success mt-3 p-3' : 'status-error mt-3 p-3';
        statusDiv.style.display = 'block';
        
        if (type === 'success') {
            setTimeout(() => {
                statusDiv.style.display = 'none';
            }, 5000);
        }
    }
    });

});

// modal.addEventListener('hidden.bs.modal', function () {
//     const editor = tinymce.get('textarea2');
//     if (editor) editor.remove();
// });