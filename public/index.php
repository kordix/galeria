<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="lightbox.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Option 1: Include in HTML -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

  <title>Galeria</title>
  <style>
    .file {
      width: 150px;
      height: 150px;
      padding: 10px;
      margin: 5px;
      border: 1px #AAA solid;
      position: relative;
      box-shadow: -2px -2px 2px #CCC;
      cursor: pointer;
    }

    .folder {
      padding: 10px;
      margin: 5px;
      border: 1px black solid;
      cursor: pointer;
      font-weight: bold;
      color: #007bff;
    }

    .folder:hover {
      opacity: 0.6
    }


    .file>p {
      word-wrap: break-word
    }

    .activefolder {
      background: #E6F4F1;
    }

    .active {
      font-weight: bold;
      border: 1px gray solid;
      color: rgba(0, 0, 0, .7);
    }

    .marginedit {
      margin-bottom: 50px;
    }

    .bi-gear:hover{
      color:red;
      cursor:pointer;
    }

  </style>

  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="mybootstrap.css">

  </script>
</head>

<body>

  <?php require 'navbar.php'; ?>

  <div class="container mt-2"  v-if="adminmode">
    <div>
      <!-- <a href="/uploading.html" style="margin-right:50px;font-size:20px;text-decoration:none;font-family:arial">Uploading strona</a> -->

     <div style="display: flex; flex-wrap: wrap;" id="kategorie">
          <div style="position: relative;" v-for="elem in filteredCategories">
            <div class="kafelek">
              <p @click="category_id=elem.id" class="folder" :class="{activefolder:elem.id==category_id}">{{elem.title}}</p>
              <button v-if="editmode" class="btn-sm btn-danger" @click="deletecategory(elem.id)" style="position:absolute;top:0px;right:0px">x</button>
            </div>
          </div>
      </div>


      <p style="display:none" @click="folder='inne';loadData()" class="folder" :class="{activefolder:folder=='inne'}">Inne </p>

      <div style="display:flex;flex-wrap:wrap;margin-bottom:50px" class="galeria">
        <div v-for="(elem,index) in filtered">
          <div class="file" :class="{marginedit:editmode}" :num="index">
            <button v-if="editmode" class="btn-sm btn-danger" @click="usun(elem.filename)" style="border-radius:100%;position:absolute;left: 120px;top:0px">x</button>
            <!-- <button v-if="editmode" class="btn-sm btn-warning" @click="rename(elem)" style="position:absolute;bottom: -40px;">rename</button> -->

            <select name="" id="" style="position:absolute;bottom:-40px;left:0px;" v-if="editmode" v-model="elem.category_id" @change="updateCategory(elem.id)">
              <option :value="categ.id" v-for="categ in categories">{{categ.title}}</option>
            </select>
            <button v-if="editmode" class="btn-sm btn-info" @click="resize(elem)" style="position:absolute;bottom:-40px;left:80px;">resize</button>


            <p><a :href="'/uploads/'+folder+'/'+elem.filename">{{prepareName(elem.filename)}}</a></p>
            <img :num="index" :src="'/uploads/upload/'+elem.filename" style="max-height:100px" alt="obrazek" class="img-fluid" v-if="getFileExt(elem.filename) == 'jpg' || getFileExt(elem.filename) == 'png'">
          </div>
        </div>
      </div>

      <div v-if="renaming">
        <label for=""></label>
        <input type="text" v-model="newfilename">
        <button @click="postRename">Zmień nazwę</button>
      </div>

      <br><br><br>

      <div id="lightbox">
        <img id="lightbox-img">
        <button class="btn btn-success" id="gallerynextbutton">Next</button>
      </div>

      <button class="btn btn-warning" @click="editmode = !editmode" v-if="adminmode">Edytuj</button>


      <br><br><br><br><br>
      
  


      <div v-if="settingsbool">
        <br>
        <input type="text" placeholder="dodaj kategorię" v-model="categoryadd">
        <button @click="addcategory">Dodaj</button>
      </div>

      <div v-show="uploadbool">
          <form action="/api/upload3.php" method="post" enctype="multipart/form-data">

          <div class="mb-2">
              <label for=""> Folder:</label>
              <select name="folder" id="folder">
                  <option value="upload">Upload</option>
                  <option value="journeys">Podróże</option>
                  <option value="pliki">Pliki</option>
                  <option value="various">Różne</option>
                  <option value="inne">INNE</option>
                  <option value="wspomnienia">Wspomnienia</option>
                  <option value="cringe">CRINGE</option>

              </select>
          </div>

          <div class="mb-2">
              <label for=""> Dodaj plik:</label>
              <input type="file" name="file" id="fileToUpload" @change="upload($event)">
              <input type="submit" value="Upload File" name="submit" id="submitbutton" style="display:none">
          </div>

          <p id="loading" style="opacity:0;color:red"><b>Ładowanie...</b></p>

      </form>

      <canvas id="mycanvas"></canvas>

    </div>


    </div>
  </div>
  <button @click="passwordbool = true" v-if="!passwordbool"></button>

      <input v-model="password" v-if="passwordbool && !adminmode" type="password">
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js"></script>


<script src="upload.js">

</script>


  <script>
    // document.querySelector('.navbar-nav').querySelector(`a[href="${window.location.pathname}"]`).classList.add('active');


    let app = new Vue({
      el: '#app',
      data: {
        category_id:1,
        categoryadd:'',
        files: [],
        folder: 'upload',
        renaming: false,
        oldfilename: '',
        newfilename: '',
        editmode: false,
        categories:[],
        settingsbool:false,
        uploadbool:false,
        password:'',
        passwordbool:false
      },
      mounted() {
        this.loadData();
        // runUploadFunctionality();

      },
      computed:{
        adminmode(){
          return this.password == 'clubmate' ? true : false;
        },
        filtered(){
          let self = this;
          return this.files.filter((el)=>el.category_id == self.category_id)
        },
        filteredCategories(){
          if(this.adminmode){
            return this.categories;
          }else{
            return this.categories.filter(el=>el.title != 'Cringe')
          }
        }
      },
      methods: {
        deletecategory(id){
          let self = this;
           fetch('/api/deletecateg.php?id='+id).then((res) => {
            self.loadData();
          });
        },
        updateCategory(id){
          let elem = this.files.find(el=>el.id == id)
          axios.post('api/update.php',elem);
        },
        addcategory(){
          axios.post('api/addcategory.php',{title:this.categoryadd});
          this.loadData();
        },
        getFileExt(file) {
          return file.split('.').pop();
        },
        prepareName(str) {
          let parts = str.split('.');
          let name = parts[0]
          let ext = parts[1]
          if (parts[0].length > 12) name = name.slice(0, 12) + '...';
          if (ext == 'jpg') {
            return name;
          } else {
            return name + '.' + ext;
          }

        },
        loadData() {
          let self = this;
          // fetch('viewfiles.php?folder=' + this.folder).then((res) => res.json()).then((res) => {
          //   self.files = res;
          //   self.files.splice(0, 2)
          // });

           fetch('/api/dane.php').then((res) => res.json()).then((res) => {
             self.files = res;
           });

            fetch('/api/categories.php').then((res) => res.json()).then((res) => {
             self.categories = res;
           });

        },
        usun(argument) {
          let self = this;
          fetch('/api/delete.php?folder=uploads&image=' + argument).then((res) => {
            this.loadData();
          });
        },
        rename(file) {
          fetch('/api/delete.php?folder=' + this.folder + '&image=' + argument).then((res) => {
            location.reload()
          });
        },
        rename(file) {
          this.oldfilename = file;
          this.newfilename = file;
          this.renaming = true;
        },
        postRename() {
          fetch('/api/rename.php?folder=' + this.folder + '&nazwa=' + this.oldfilename + '&nazwa2=' + this.newfilename).then((res) => {
            location.reload()
          });
        },
        resize(file) {
          console.log(file);
          fetch('/api/converter.php?folder=' + this.folder + '&image=' + file).then((res) => {
            location.reload()
          });

        },
        upload(event){
          let self = this;
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
                        self.loadData()
                    })

            });

            // Set the image source to the data URL
            img.src = reader.result;
        });

        // Read the file data as a data URL
        reader.readAsDataURL(file);
        }


      },

    })
  </script>



  <script src="lightbox.js"></script>

</body>

</html>