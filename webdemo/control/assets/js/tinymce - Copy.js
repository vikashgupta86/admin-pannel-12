
document.addEventListener('focusin', (e) => {
  if (e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root") !== null) {
    e.stopImmediatePropagation();
  }
});


window.showRTF = function(selector = '#textarea2') {
    if (typeof tinymce === 'undefined') {
        console.error("TinyMCE library not loaded!");
        return;
    }

//    console.log("Initializing TinyMCE for " + selector);
    
    const elementId = selector.replace('#', '');
    if (tinymce.get(elementId)) {
        tinymce.remove(selector);
    }

    tinymce.init({
        selector: selector,
        license_key: 'gpl', 
        height: 500,
        promotion: false,
        branding: false,
        statusbar: true,
        elementpath: true,
        
        menubar: 'insert format table', 
        
        plugins: 'advlist lists link anchor searchreplace table',
        
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link uploadimage table forecolor backcolor',
        
        toolbar_mode: 'sliding', 
        
        
        images_upload_url: 'upload_image.php',
        automatic_uploads: true,
        skin: 'oxide',
        content_css: 'default',
        
        relative_urls: false,
        remove_script_host: true,
        convert_urls: true,

        image_dimensions: false,
        image_description: false,
        image_class_list: [
            { title: 'Responsive Image', value: 'img-fluid w-100 h-auto' }
        ],
        
        paste_data_images: false,
        images_reuse_filename: false,
        image_advtab: false,
        
        contextmenu: 'link table configurepermanentpen', 

        images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', 'upload_image.php');

            const maxSize = 500 * 1024;
            if (blobInfo.blob().size > maxSize) {
                reject('Image too large. Max 500KB allowed.');
                return;
            }

            xhr.upload.onprogress = (e) => {
                progress(e.loaded / e.total * 100);
            };

            xhr.onload = () => {
                if (xhr.status < 200 || xhr.status >= 300) {
                    try {
                        const errJson = JSON.parse(xhr.responseText);
                        reject(errJson.error || 'HTTP Error: ' + xhr.status);
                    } catch(e) {
                        reject('HTTP Error: ' + xhr.status);
                    }
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

            const csrfToken = document.querySelector('input[name="__csrf_magic"]')?.value || 
                              window.CSRF_TOKEN || 
                              (typeof csrf_get_tokens === 'function' ? csrf_get_tokens() : '');
            
            if (csrfToken) {
                formData.append('__csrf_magic', csrfToken);
            }

            xhr.send(formData);
        }),
    

        
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:16px; color: #1e293b; background-color: #fff; } ' +
            'img { max-width: 100%; height: auto; display: block; margin: 10px 0; }',

        setup: (editor) => {
            editor.ui.registry.addButton('uploadimage', {
                icon: 'image',
                tooltip: 'Secure Image Upload',
                onAction: () => {
                    openSecureImageDialog(editor);
                }
            });
        }


    });
};



function openSecureImageDialog(editor) {
    let uploadedUrl = '';
    
    const dialog = editor.windowManager.open({
        title: 'Secure Image Upload',
        body: {
            type: 'panel',
            items: [
                {
                    type: 'htmlpanel',
                    name: 'uploader_ui',
                    html: `
                        <div id="secure-upload-wrapper" style="text-align: center; padding: 20px; min-height: 180px; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 2px dashed #e2e8f0; border-radius: 8px; background: #f8fafc;">
                            <div id="upload-stage">
                                <div style="font-size: 32px; color: #94a3b8; margin-bottom: 10px;">
                                    <i class="fa fa-cloud-upload"></i>
                                </div>
                                <button type="button" id="trigger-upload" class="tox-button" style="padding: 10px 20px; background-color: #3b82f6; border-color: #3b82f6;">
                                    Pick Image File
                                </button>
                                <p style="margin-top: 10px; color: #64748b; font-size: 13px; font-weight: 500;">JPG, PNG up to 500KB</p>
                            </div>
                            <div id="preview-stage" style="display: none; width: 100%;">
                                <div style="margin-bottom: 20px; display: flex; justify-content: center;">
                                    <div style="padding: 4px; border: 1px solid #cbd5e1; border-radius: 6px; background: #fff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                        <img id="upload-mini-preview" src="" style="max-width: 140px; max-height: 140px; display: block; object-fit: contain;">
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: center; gap: 12px;">
                                    <button type="button" id="reupload-btn" class="tox-button tox-button--secondary" style="background-color: #f1f5f9; color: #475569;">Change Image</button>
                                    <button type="button" id="remove-btn" class="tox-button tox-button--secondary" style="background-color: #fee2e2; color: #dc2626; border-color: #fecaca;">Remove</button>
                                </div>
                            </div>
                            <input type="file" id="secure-file-input" accept="image/jpeg, image/png" style="display: none;">
                        </div>
                    `
                }
            ]
        },
        buttons: [
            {
                type: 'cancel',
                text: 'Cancel'
            },
            {
                type: 'submit',
                name: 'insert_btn',
                text: 'Insert Image',
                primary: true,
                disabled: true
            }
        ],
        onSubmit: (api) => {
            if (uploadedUrl) {
                editor.insertContent(`<img src="${uploadedUrl}" class="img-fluid w-100 h-auto">`);
            }
            api.close();
        }
    });

    setTimeout(() => {
        const fileInput = document.getElementById('secure-file-input');
        const triggerBtn = document.getElementById('trigger-upload');
        const reuploadBtn = document.getElementById('reupload-btn');
        const removeBtn = document.getElementById('remove-btn');
        const previewStage = document.getElementById('preview-stage');
        const uploadStage = document.getElementById('upload-stage');
        const previewImg = document.getElementById('upload-mini-preview');
        const wrapper = document.getElementById('secure-upload-wrapper');

        const resetDialog = () => {
            uploadedUrl = '';
            previewImg.src = '';
            previewStage.style.display = 'none';
            uploadStage.style.display = 'block';
            wrapper.style.borderStyle = 'dashed';
            dialog.setEnabled('insert_btn', false);
        };

        const handleFileUpload = (file) => {
            if (!file) return;

            if (file.size > 500 * 1024) {
                editor.notificationManager.open({ text: 'Image too large. Max 500KB allowed.', type: 'error' });
                return;
            }

            const formData = new FormData();
            formData.append('file', file);

            const csrfToken = document.querySelector('input[name="__csrf_magic"]')?.value || 
                              window.CSRF_TOKEN || 
                              (typeof csrf_get_tokens === 'function' ? csrf_get_tokens() : '');
            
            if (csrfToken) formData.append('__csrf_magic', csrfToken);

            triggerBtn.disabled = true;
            triggerBtn.innerText = 'Uploading...';

            fetch('upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(json => {
                if (json.location) {
                    uploadedUrl = json.location;
                    previewImg.src = uploadedUrl;
                    uploadStage.style.display = 'none';
                    previewStage.style.display = 'block';
                    wrapper.style.borderStyle = 'solid';
                    dialog.setEnabled('insert_btn', true);
                } else {
                    throw new Error(json.error || 'Upload failed');
                }
            })
            .catch(err => {
                editor.notificationManager.open({ text: err.message, type: 'error' });
            })
            .finally(() => {
                triggerBtn.disabled = false;
                triggerBtn.innerText = 'Pick Image File';
            });
        };

        if (triggerBtn) triggerBtn.onclick = () => fileInput.click();
        if (reuploadBtn) reuploadBtn.onclick = () => fileInput.click();
        if (removeBtn) removeBtn.onclick = resetDialog;
        
        if (fileInput) {
            fileInput.onchange = (e) => {
                handleFileUpload(e.target.files[0]);
                e.target.value = ''; 
            };
        }

    }, 100);
}

$(document).on('hidden.bs.modal', '#PopWind', function () {
    if (typeof tinymce !== 'undefined') {
        tinymce.remove('#textarea2');
    }
});