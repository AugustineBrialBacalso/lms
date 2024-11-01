<html>
  <head>
    <title>Vue.js Autocomplete Textbox with PHP Mysql</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  </head>
  <body>
    <br />
    <br />
    <div class="container" id="autocomplete_app">
      <h3 align="center">Vue.js Autocomplete Textbox with PHP Mysql</h3>
      <br />
      <br />
      <br />
      <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
          <auto-complete></auto-complete>
        </div>
        <div class="col-md-3">

        </div>
      </div>
    </div>
  </body>
</html>

<script>

  Vue.component('auto-complete', {
    template:`
    <div>
      <input type="text" placeholder="Enter Country name..." v-model="query" @keyup="getData()" autocomplete="off" class="form-control input-lg" />
      <div class="panel-footer" v-if="search_data.length">
        <ul class="list-group">
          <a href="#" class="list-group-item" v-for="data1 in search_data" @click="getName(data1.title)">{{ data1.title }}</a>
        </ul>
      </div>
    </div>
    `,
    data:function(){
      return{
        query:'',
        search_data:[]
      }
    },
    methods:{
      getData:function(){
        this.search_data = [];
        axios.post('fetch.php', {
          query:this.query
        }).then(response => {
          this.search_data = response.data;
        });
      },
      getName:function(name){
        this.query = name;
        this.search_data = [];
      }
    }
  });

  var application = new Vue({
    el:'#autocomplete_app'
  });

</script>