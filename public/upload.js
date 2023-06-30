function runUploadFunctionality() {

    // Get the input element where the user selects the file
    const input = document.querySelector('input[type="file"]');

    // Listen for the change event on the input element
    input.addEventListener('change', (event) => {
        // Get the selected file
        const file = event.target.files[0];

        // Create a new FileReader object
        const reader = new FileReader();

        // Listen for the load event on the reader
        reader.addEventListener('load', () => {
            // Create a new image object
            const img = new Image();


            const fileType = file.type; // Get the MIME type of the file

            // Check if the file type is an image
            if (fileType.startsWith('image/')) {
                console.log('File is an image.');
            } else {
                console.log('File is not an image.');
                document.querySelector('#submitbutton').style.display = 'block'
            }


            // Listen for the load event on the image
            img.addEventListener('load', () => {
                // Create a canvas element
                const canvas = document.getElementById('mycanvas');

                // Get the canvas context
                const ctx = canvas.getContext('2d');

                let ratio = img.width / img.height;

                if (img.width > 1200) {
                    img.width = 1200;
                    img.height = img.width / ratio;
                }
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL();
                const blob = dataURLtoBlob(dataUrl);

                const formData = new FormData();
                formData.append('file', blob, file.name);
                formData.append('folder', document.querySelector('#folder').value);
                document.querySelector('#loading').style.opacity = 1;

                fetch('/api/upload3.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(function (response) {
                        document.querySelector('#loading').style.opacity = 0;
                    })

            });

            // Set the image source to the data URL
            img.src = reader.result;
        });

        // Read the file data as a data URL
        reader.readAsDataURL(file);
    });

}

// Helper function to convert a data URL to a blob
function dataURLtoBlob(dataUrl) {
    const arr = dataUrl.split(',');
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    let n = bstr.length;
    const u8arr = new Uint8Array(n);
    while (n--) {
        u8arr[n] = bstr.charCodeAt(n);
    }
    return new Blob([u8arr], {
        type: mime
    });
}