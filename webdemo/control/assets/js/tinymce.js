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
        
        /* ADDED 'image' to plugins to enable the standard dialog features */
    plugins: 'advlist lists link anchor searchreplace table image',
    
    // 2. Enable the file picker for links [cite: 7]
    file_picker_types: 'file image',
    
    // 3. The logic to handle the upload when the browse icon is clicked
    file_picker_callback: (callback, value, meta) => {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        
        // Accept images for the image tool, or PDFs/Files for the link tool
        if (meta.filetype === 'image') {
            input.setAttribute('accept', 'image/*');
        } else if (meta.filetype === 'file') {
            input.setAttribute('accept', '.pdf,.doc,.docx');
        }

        input.onchange = function () {
            const file = this.files[0];
            const formData = new FormData();
            formData.append('file', file);

            // Use your existing CSRF logic [cite: 19, 20]
            const csrfToken = document.querySelector('input[name="__csrf_magic"]')?.value || window.CSRF_TOKEN;
            if (csrfToken) formData.append('__csrf_magic', csrfToken);

            // Upload to your existing PHP handler [cite: 9]
            fetch('upload_image.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(json => {
                if (json.location) {
                    // This puts the URL into the Link/Image dialog [cite: 17]
                    callback(json.location, { text: file.name, title: file.name });
                }
            })
            .catch(err => console.error("Upload failed:", err));
        };

        input.click();
    },                
        
        /* ADDED 'image' to toolbar so you have the option for the standard dialog too */
        toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | ' +
                 'bullist numlist outdent indent | link uploadimage image table forecolor backcolor',
        
        toolbar_mode: 'sliding', 
        
    images_upload_url: 'upload_image.php',
        automatic_uploads: true,
        skin: 'oxide',
        content_css: 'default',
        
        relative_urls: false,
        remove_script_host: true,
        convert_urls: true,

        /* CHANGED: Enable these to allow user input for size and title */
        image_dimensions: true, 
        image_title: true,
        image_description: true,
        
        /* UPDATED: Cleaned up classes to allow manual width/height to work */
        image_class_list: [
            { title: 'None', value: '' },
          { title: 'Responsive Image', value: 'img-fluid' }
        ],
        
        paste_data_images: false,
        images_reuse_filename: false,
        image_advtab: true, // Enables the Advanced tab for spacing/borders
        
        contextmenu: 'link table image configurepermanentpen', 

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
            'img { max-width: 100%; height: auto; display: inline-block; margin: 10px 0; }',

        
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
                        <div id="secure-upload-wrapper" style="text-align: center; padding: 15px; border: 2px dashed #e2e8f0; border-radius: 8px; background: #f8fafc;">
                            <div id="upload-stage">
                                <button type="button" id="trigger-upload" class="tox-button">Pick Image File</button>
                            </div>
                            <div id="preview-stage" style="display: none; width: 100%;">
                                <img id="upload-mini-preview" src="" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                                <div style="margin-top:10px;">
                                    <button type="button" id="remove-btn" class="tox-button tox-button--secondary">Remove</button>
                                </div>
                            </div>
                            <input type="file" id="secure-file-input" accept="image/jpeg, image/png" style="display: none;">
                        </div>
                    `
                },
                /* ADDED: Manual inputs for Title and Dimensions in the custom dialog */
                { type: 'input', name: 'img_title', label: 'Image Title' },
                {
                    type: 'grid',
                    columns: 2,
                    items: [
                        { type: 'input', name: 'img_width', label: 'Width (px)' },
                        { type: 'input', name: 'img_height', label: 'Height (px)' }
                    ]
                }
            ]
        },
        buttons: [
            { type: 'cancel', text: 'Cancel' },
            { type: 'submit', name: 'insert_btn', text: 'Insert Image', primary: true, disabled: true }
        ],
        onSubmit: (api) => {
            const data = api.getData();
            if (uploadedUrl) {
                // Construct the img tag using manual inputs
                const widthAttr = data.img_width ? ` width="${data.img_width}"` : '';
                const heightAttr = data.img_height ? ` height="${data.img_height}"` : '';
                const titleAttr = data.img_title ? ` title="${data.img_title}" alt="${data.img_title}"` : '';
                
                editor.insertContent(`<img src="${uploadedUrl}"${widthAttr}${heightAttr}${titleAttr} class="img-fluid">`);
            }
            api.close();
        }
    });

    /* ... Keep the rest of your handleFileUpload and event listener logic below ... */
    setTimeout(() => {
        const fileInput = document.getElementById('secure-file-input');
        const triggerBtn = document.getElementById('trigger-upload');
        const removeBtn = document.getElementById('remove-btn');
        const previewStage = document.getElementById('preview-stage');
        const uploadStage = document.getElementById('upload-stage');
        const previewImg = document.getElementById('upload-mini-preview');

        if (triggerBtn) triggerBtn.onclick = () => fileInput.click();
        if (removeBtn) removeBtn.onclick = () => {
            uploadedUrl = '';
            previewStage.style.display = 'none';
            uploadStage.style.display = 'block';
            dialog.setEnabled('insert_btn', false);
        };

        if (fileInput) {
            fileInput.onchange = (e) => {
                const file = e.target.files[0];
                if (!file) return;
                
                const formData = new FormData();
                formData.append('file', file);
                
                fetch('upload_image.php', { method: 'POST', body: formData })
                .then(res => res.json())
                .then(json => {
                    if (json.location) {
                        uploadedUrl = json.location;
                        previewImg.src = uploadedUrl;
                        uploadStage.style.display = 'none';
                        previewStage.style.display = 'block';
                        dialog.setEnabled('insert_btn', true);
                    }
                });
            };
        }
    }, 100);
}