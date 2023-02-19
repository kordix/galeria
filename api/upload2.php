<canvas id="mycanvas"></canvas>

<form action="/api/upload2.php" method="post" enctype="multipart/form-data">

    <div class="mb-2">
        <label for=""> Folder:</label>
        <select name="folder">
            <option value="journeys">Podróże</option>
            <option value="pliki">Pliki</option>
            <option value="various">Różne</option>
            <option value="inne">INNE</option>
            <option value="wspomnienia">Wspomnienia</option>
            <option value="cringe">CRINGE</option>

        </select>
    </div>


    <div class="mb-2">

        <label for="">Nazwa pliku:</label>
        <input type="text" name="filename">
    </div>


    <div class="mb-2">

        <label for=""> Dodaj plik:</label>
        <input type="file" name="file" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </div>

</form>



<script>
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
                // Set the canvas dimensions to the image dimensions
                canvas.width = img.width;
                // canvas.width = `300`;
                canvas.height = img.height;
                // canvas.height = 300;

                // Draw the image onto the canvas
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                // Get the canvas data as a data URL
                const dataUrl = canvas.toDataURL();

                // Create a new blob object from the data URL
                const blob = dataURLtoBlob(dataUrl);

                // Create a new FormData object and append the blob to it
                const formData = new FormData();
                formData.append('file', blob, file.name);

                // Send the form data to the server using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload2.php');
                xhr.send(formData);
            });

            // Set the image source to the data URL
            img.src = reader.result;
        });

        // Read the file data as a data URL
        reader.readAsDataURL(file);
    });

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
</script>


<?php
// Get the uploaded file
$file = $_FILES['file']['tmp_name'];

@$folder = $_POST['folder'];


// Set the upload directory


$upload_dir = "../uploads/" . $folder . '/';

// Generate a unique filename for the uploaded file
$filename = $_FILES['file']['name'];

// Set the target path for the uploaded file
$target_path = $upload_dir . $filename;

// Move the uploaded file to the target path
if (move_uploaded_file($file, $target_path)) {
    // File was successfully uploaded
    echo "File uploaded successfully: " . $filename;
} else {
    // Error uploading file
    echo "Error uploading file";
}


?>