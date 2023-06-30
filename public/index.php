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

  <div class="container mt-2">
    <div>
      <!-- <a href="/uploading.html" style="margin-right:50px;font-size:20px;text-decoration:none;font-family:arial">Uploading strona</a> -->

     <div style="display: flex; flex-wrap: wrap;" id="kategorie">
          <div style="position: relative;" v-for="elem in categories">
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

      <button class="btn btn-warning" @click="editmode = !editmode">Edytuj</button>


      <div v-if="settingsbool">
<br>
      <input type="text" placeholder="dodaj kategorię" v-model="categoryadd">
      <button @click="addcategory">Dodaj</button>
      </div>


    </div>
  </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.2/axios.min.js"></script>
  <script>
    document.querySelector('.navbar-nav').querySelector(`a[href="${window.location.pathname}"]`).classList.add('active');


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
        settingsbool:false
      },
      mounted() {
        this.loadData();

      },
      computed:{
        filtered(){
          let self = this;
          return this.files.filter((el)=>el.category_id == self.category_id)
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

        }
      },

    })
  </script>


  <script src="lightbox.js"></script>

</body>

</html>