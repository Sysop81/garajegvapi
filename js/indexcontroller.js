
window.onload = function () {
    var app = new Vue({
        el: '#app',
        data: {
        loading: null,  
        loadingSetData:{
            consumibles:{
                initial:true,
                loading:false,
                loaded:false,
            },
            mecanicos:{
                initial:true,
                loading:false,
                loaded:false,
            }
        },  
        isConected: null,
        isCorrectCredentials: false,
        showStatusCon: false,
        showSaveOk:false,
        configuracion:{
            ip: null,
            port:null,
            bd:null,
            user:null,
            pass:null
        },
        consumibles:[],
        mecanicos:[],
        cargos : {
            'encargado': 'Encargado',
            'jefetaller':'Jefe de taller',
            'mecanicoof1':'Oficial 1ª',
            'mecanicoof2':'Oficial 2ª',
            'aprendiz':'Aprendiz'

        },
        vehiculos:[],
        revisiones:[]
        },
        methods: {
            initialize: function(){
                this.getConsumibles();
                this.getMecanicos();
                this.getVehiculos();
                this.getRevisiones();
            },
            almacenarDatoLocal: function(key,value){
                if(!this.isCorrectCredentials) return;
                localStorage.setItem(key, value);
            },
            recuperarDatoLocal: function(key){
                return localStorage.getItem(key);
            },
            comprobarDatosConexionGuardados: function(){

                let conf =  JSON.parse(this.recuperarDatoLocal('confGarajeGV'));
                if(conf != null){
                    this.isCorrectCredentials = true;
                    this.configuracion={
                        ip: conf.ip,
                        port: conf.port,
                        bd: conf.bd,
                        user: conf.user,
                        pass: conf.pass
                    }

                    this.initialize();
                }
                
            },
            guardarConfiguracion: function(){
                
                this.almacenarDatoLocal('confGarajeGV', JSON.stringify(this.configuracion));

                let isSaveInLocal = this.recuperarDatoLocal('confGarajeGV') != null;

                if(isSaveInLocal){
                    
                    this.showSaveOk = true;
                    setTimeout(()=>{
                        this.showSaveOk = false;
                    },3000);
                }

            },
            probarConexion: function(){
                
                this.loading = true;    
                let self = this;

                fetch('../garajegvapi/php/testConeciton.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();
                    
                    self.isConected = response.result == 'ok';
                    self.isCorrectCredentials = self.isConected;
                    
                    // Mantenemos un segundo en espera adicional
                    setTimeout(()=>{
                        self.loading = false;
                        self.showStatusCon = true;    
                        self.initialize();
                    },1000);
                    
    
                });
            },
            cargarConsumibles:function(){
                this.loadingSetData.consumibles.initial = false;
                this.loadingSetData.consumibles.loading = true;
                let estadoPeticion = false;
                let self = this;
                fetch('../garajegvapi/php/setConsumibles.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();
                    
                    if(response.result == 'ok'){
                        self.getConsumibles();
                        estadoPeticion = true;
                    }
                    
                    setTimeout(()=>{
                        self.loadingSetData.consumibles.loading = false;
                        self.loadingSetData.consumibles.loaded = estadoPeticion;
                    },1000);
    
                });
            },
            cargarMecanicos: function(){
                this.loadingSetData.mecanicos.initial = false;
                this.loadingSetData.mecanicos.loading = true;
                let estadoPeticion = false;
                let self = this;
                fetch('../garajegvapi/php/setMecanicos.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();
                    
                    if(response.result == 'ok'){
                        self.getMecanicos();
                        estadoPeticion = true;
                    }
                    
                    setTimeout(()=>{
                        self.loadingSetData.mecanicos.loading = false;
                        self.loadingSetData.mecanicos.loaded = estadoPeticion;
                        
                    },1000);
    
                });
            },
            getConsumibles : function(){
                let self = this;

                fetch('../garajegvapi/php/getListConsumibles.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();
                    
                    self.consumibles = response;
                
                });
            },
            getMecanicos : function(){
                let self = this;

                fetch('../garajegvapi/php/getListMecanicos.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();

                    self.mecanicos = response;
    
                });
            },
            getVehiculos: function(){
                let self = this;

                fetch('../garajegvapi/php/getListVehiculos.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();
                    
                    self.vehiculos = response;
                    
                });
            },
            getRevisiones: function(){
                let self = this;

                fetch('../garajegvapi/php/getListRevisiones.php?configuracion=' + JSON.stringify(this.configuracion)).then(async res => {
                    let response = await res.json();
                    
                    self.revisiones = response;
    
                });
            },
            formatearCargo: function(cargo){
                return this.cargos[cargo];
            }
        },
        mounted: function(){
            this.$nextTick(function () {
                
                $( "#tabs" ).tabs();
                this.comprobarDatosConexionGuardados();
               
            });
        }
    })
}
