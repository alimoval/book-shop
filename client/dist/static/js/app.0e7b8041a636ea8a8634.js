webpackJsonp([1],{0:function(t,e){},FZzG:function(t,e){},NHnr:function(t,e,s){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var r=s("7+uW"),a={name:"App",data:function(){return{userId:null,msg:null}},created:function(){this.getUserFromLocalStorage()},methods:{getUserFromLocalStorage:function(){this.userId=localStorage.getItem("user_id")},setUserID:function(t){this.userId=t,this.$router.push("/")},logout:function(){this.userId=null,localStorage.removeItem("user_id"),this.$router.push("/")}}},i={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"app"}},[s("nav",{staticClass:"navbar navbar-light bg-dark",staticStyle:{"font-weight":"400"}},[s("div",{staticClass:"container"},[s("router-link",{staticClass:"nav-link",attrs:{to:"/"}},[t._v("CARS SHOP")]),t._v(" "),t.userId?s("router-link",{staticClass:"nav-link",attrs:{to:"/orders"}},[t._v("Orders")]):t._e(),t._v(" "),s("ul",{staticClass:"nav justify-content-end"},[t.userId?t._e():s("li",{staticClass:"nav-item"},[s("router-link",{staticClass:"nav-link",attrs:{to:"/login"}},[t._v("LOG IN")])],1),t._v(" "),t.userId?t._e():s("li",{staticClass:"nav-item"},[s("router-link",{staticClass:"nav-link",attrs:{to:"/register"}},[t._v("REGISTER")])],1),t._v(" "),t.userId?s("li",{staticClass:"nav-item"},[s("a",{staticClass:"nav-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[t._v("LOG OUT")])]):t._e()])],1)]),t._v(" "),s("div",{staticClass:"row",staticStyle:{"min-height":"50px"}},[s("div",{staticClass:"col-sm-12"},[s("div",{staticClass:"message"},[t._v(t._s(t.msg))])])]),t._v(" "),s("router-view",{attrs:{userID:t.userId},on:{setUser:function(e){t.setUserID(e)}}})],1)},staticRenderFns:[]};var n=s("VU/8")(a,i,!1,function(t){s("FZzG")},null,null).exports,o=s("8+8L"),l=s("/ocq"),c={name:"home",props:["userID"],data:function(){return{searchBrand:"",searchModel:"",cars:[],fullCarsArray:[]}},created:function(){this.fetchCars()},computed:{filteredByBrandCars:function(){var t=this;return this.cars.filter(function(e){return e.tm.toLowerCase().includes(t.searchBrand.toLowerCase())})},filteredByModelCars:function(){var t=this;return this.cars.filter(function(e){return e.model.toLowerCase().includes(t.searchModel.toLowerCase())})}},methods:{fetchCars:function(){var t=this;fetch("http://192.168.0.15/~user16/rest/client/api/cars/").then(function(t){if(t.ok)return console.log(t),t.json();throw new Error("Network response was not ok")}).then(function(e){e.data.forEach(function(e){t.cars.push({id:e.id,model:e.model,tm:e.tm,price:e.price,images:e.images})})}).catch(function(t){console.log(t)}),this.fullCarsArray=this.cars},filterByBrand:function(){""!==this.searchBrand?this.cars=this.filteredByBrandCars:this.cars=this.fullCarsArray},filterByModel:function(){""!==this.searchModel?this.cars=this.filteredByModelCars:this.cars=this.fullCarsArray},resetFilter:function(){this.searchBrand="",this.searchModel="",this.filterByBrand()}}},u={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},[s("div",{staticClass:"row"},[s("div",{staticClass:"col-sm-3 d-flex justify-content-start"},[s("ul",{staticClass:"list-group"},[s("li",{staticClass:"list-group-item"},[s("div",{staticClass:"input-group mb-3"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.searchBrand,expression:"searchBrand"}],staticClass:"form-control",attrs:{type:"text",placeholder:"Brand search"},domProps:{value:t.searchBrand},on:{keyup:function(e){return e.preventDefault(),t.filterByBrand(e)},input:function(e){e.target.composing||(t.searchBrand=e.target.value)}}})])]),t._v(" "),s("li",{staticClass:"list-group-item"},[s("div",{staticClass:"input-group mb-3"},[s("input",{directives:[{name:"model",rawName:"v-model",value:t.searchModel,expression:"searchModel"}],staticClass:"form-control",attrs:{type:"text",placeholder:"Model search"},domProps:{value:t.searchModel},on:{keyup:function(e){return e.preventDefault(),t.filterByModel(e)},input:function(e){e.target.composing||(t.searchModel=e.target.value)}}})])]),t._v(" "),s("li",{staticClass:"list-group-item"},[s("div",{staticClass:"input-group-append"},[s("button",{staticClass:"btn btn-outline-secondary",attrs:{type:"button"},on:{click:t.resetFilter}},[t._v("Reset")])])])])]),t._v(" "),s("div",{staticClass:"col-sm-9"},[s("div",{staticClass:"row",staticStyle:{"padding-top":"10px"}},t._l(t.cars,function(e){return s("div",{key:e.id,staticClass:"col-sm-4"},[s("router-link",{attrs:{to:"/"+e.id}},[s("div",{staticClass:"card"},[s("img",{staticClass:"card-img-top img-fluid",attrs:{src:e.images,alt:"Card image cap"}}),t._v(" "),s("div",{staticClass:"card-body"},[s("h5",{staticClass:"card-title",staticStyle:{color:"grey"}},[t._v(t._s(e.tm)+" "+t._s(e.model))]),t._v(" "),s("p",{staticClass:"card-text",staticStyle:{color:"tomato"}},[s("b",[t._v("$"+t._s(e.price))])])])])])],1)}))])])])},staticRenderFns:[]},d=s("VU/8")(c,u,!1,null,null,null).exports,m={name:"carDetails",props:["userID"],data:function(){return{cars:[],message:null}},created:function(){this.fetchCar(this.$route.params.id)},methods:{buyCar:function(){var t=this,e=new Date,s={user_id:this.userID,car_id:this.$route.params.id,date:e.toLocaleString("ru")};this.$http.post("http://192.168.0.15/~user16/rest/client/api/orders/",s).then(function(e){t.msg="Order Registered"}).catch(function(e){t.message=e}),this.$router.push("/thank-you")},fetchCar:function(t){var e=this;fetch("http://192.168.0.15/~user16/rest/client/api/cars/"+t).then(function(t){if(t.ok)return t.json();throw new Error("Network response was not ok")}).then(function(t){t.data.forEach(function(t){e.cars.push({id:t.id,model:t.model,tm:t.tm,price:t.price,color:t.color,year:t.year,gas:t.gas,odo:t.odo,engine:t.engine,town:t.town,images:t.images})})}).catch(function(t){e.message=t})}}},p={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},t._l(t.cars,function(e){return s("div",{key:e.id,staticClass:"row top-buffer"},[s("div",{staticClass:"col-sm-4"},[s("img",{staticClass:"img-fluid",attrs:{src:e.images,alt:"Card image cap"}})]),t._v(" "),s("div",{staticClass:"col-sm-8",staticStyle:{"text-align":"left"}},[s("h4",{staticStyle:{color:"grey"}},[t._v(t._s(e.tm)+" "+t._s(e.model))]),t._v(" "),s("p",[t._v("\n                  year: "),s("b",[t._v(t._s(e.year))])]),t._v(" "),s("p",[t._v("\n                  odometr: "),s("b",[t._v(t._s(e.odo))]),t._v(" km\n              ")]),t._v(" "),s("p",[t._v("\n                  color: "),s("b",[t._v(t._s(e.color))])]),t._v(" "),s("p",[t._v("\n                  engine type: "),s("b",[t._v(t._s(e.gas))])]),t._v(" "),s("p",[t._v("\n                  engine amount: "),s("b",[t._v(t._s(e.engine))])]),t._v(" "),s("p",[t._v("\n                  town: "),s("b",[t._v(t._s(e.town))])]),t._v(" "),s("p",{staticStyle:{color:"tomato"}},[t._v("\n                Price: "),s("b",[t._v("$"+t._s(e.price))])]),t._v(" "),t.userID?s("form",{attrs:{method:"post"},on:{submit:function(e){return e.stopPropagation(),e.preventDefault(),t.buyCar(e)}}},[s("input",{attrs:{type:"submit",value:"Buy"}})]):t._e()])])}))},staticRenderFns:[]},h=s("VU/8")(m,p,!1,null,null,null).exports,v={name:"login",data:function(){return{msg:"Welcome to the Login Page",password:null,email:null,errors:[],message:null,userId:null}},methods:{checkForm:function(t){this.email&&this.password&&this.proceedForm(),this.errors=[],this.email||this.errors.push("Требуется указать email."),this.password||this.errors.push("Требуется указать пароль.")},proceedForm:function(){var t=this,e={email:this.email,password:this.password};this.$http.post("http://192.168.0.15/~user16/rest/client/api/users/login",e).then(function(e){localStorage.setItem("user_id",e.body.id),t.$emit("setUser",e.body.id)}).catch(function(e){t.message=e})}}},f={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},[s("div",{staticClass:"title"},[s("h1",[t._v(t._s(t.msg))])]),t._v(" "),s("div",{staticClass:"row top-buffer",staticStyle:{align:"center"}},[s("div",{staticClass:"col-sm-3"}),t._v(" "),s("div",{staticClass:"col-sm-6"},[s("form",{attrs:{method:"post"},on:{submit:function(e){return e.stopPropagation(),e.preventDefault(),t.checkForm(e)}}},[t.errors.length?s("p",[s("b",[t._v("Пожалуйста исправьте указанные ошибки:")]),t._v(" "),s("ul",t._l(t.errors,function(e){return s("li",{key:e.id},[t._v(t._s(e))])}))]):t._e(),t._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"emailInput"}},[t._v("Email address")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.email,expression:"email"}],staticClass:"form-control",attrs:{type:"email",placeholder:"Enter email",id:"emailInput"},domProps:{value:t.email},on:{input:function(e){e.target.composing||(t.email=e.target.value)}}}),t._v(" "),s("small",{staticClass:"form-text text-muted",attrs:{id:"emailHelp"}},[t._v("We'll never share your email with anyone else.")])]),t._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"pass"}},[t._v("Password")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],staticClass:"form-control",attrs:{type:"password",id:"pass",placeholder:"Password"},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}})]),t._v(" "),s("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])])])])])},staticRenderFns:[]},_=s("VU/8")(v,f,!1,null,null,null).exports,g={name:"orders",props:["userID"],data:function(){return{orders:[]}},created:function(){this.userID&&this.fetchOrders(this.userID)},methods:{fetchOrders:function(t){var e=this;fetch("http://192.168.0.15/~user16/rest/client/api/orders/?userID="+t).then(function(t){if(t.ok)return t.json();throw new Error("Network response was not ok")}).then(function(t){t.data.forEach(function(t){e.orders.push({id:t.id,model:t.model,name:t.name,date:t.date})})}).catch(function(t){console.log(t)})}}},C={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},[s("div",{staticClass:"row",staticStyle:{"padding-top":"20px"}},t._l(t.orders,function(e){return s("div",{key:e.id,staticClass:"col-sm-4"},[s("router-link",{attrs:{to:"/orders/"+e.id}},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-body"},[s("h5",{staticClass:"card-title",staticStyle:{color:"grey"}},[t._v(t._s(e.name)+" "+t._s(e.car))]),t._v(" "),s("p",{staticClass:"card-text",staticStyle:{color:"tomato"}},[s("b",[t._v(t._s(e.date))])])])])])],1)}))])},staticRenderFns:[]},y=s("VU/8")(g,C,!1,null,null,null).exports,w={name:"register",props:["userID"],data:function(){return{msg:"Welcome to the Register Page",password:null,email:null,name:null,errors:[],message:null}},methods:{checkForm:function(t){this.email&&this.password&&this.name&&this.proceedForm(),this.errors=[],this.email||this.errors.push("enter email."),this.password||this.errors.push("enter password."),this.name||this.errors.push("enter user name.")},proceedForm:function(){var t=this,e={email:this.email,password:this.password,name:this.name};this.$http.post("http://192.168.0.15/~user16/rest/client/api/users/",e).then(function(e){t.msg="User Registered",console.log(e)}).catch(function(e){t.message=e}),this.$router.push("/")}}},b={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},[s("div",{staticClass:"title"},[s("h2",[t._v(t._s(t.msg))])]),t._v(" "),s("div",{staticClass:"row top-buffer",staticStyle:{align:"center"}},[s("div",{staticClass:"col-sm-3"}),t._v(" "),s("div",{staticClass:"col-sm-6"},[s("form",{attrs:{method:"post"},on:{submit:function(e){return e.stopPropagation(),e.preventDefault(),t.checkForm(e)}}},[s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"name"}},[t._v("Name")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.name,expression:"name"}],staticClass:"form-control",attrs:{type:"text",placeholder:"user name",id:"name"},domProps:{value:t.name},on:{input:function(e){e.target.composing||(t.name=e.target.value)}}})]),t._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"emailInput"}},[t._v("Email address")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.email,expression:"email"}],staticClass:"form-control",attrs:{type:"email",placeholder:"email",id:"emailInput"},domProps:{value:t.email},on:{input:function(e){e.target.composing||(t.email=e.target.value)}}}),t._v(" "),s("small",{staticClass:"form-text text-muted",attrs:{id:"emailHelp"}},[t._v("We'll never share your email with anyone else.")])]),t._v(" "),s("div",{staticClass:"form-group"},[s("label",{attrs:{for:"pass"}},[t._v("Password")]),t._v(" "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],staticClass:"form-control",attrs:{type:"password",id:"pass",placeholder:"password"},domProps:{value:t.password},on:{input:function(e){e.target.composing||(t.password=e.target.value)}}})]),t._v(" "),s("button",{staticClass:"btn btn-primary",attrs:{type:"submit"}},[t._v("Submit")])])])])])},staticRenderFns:[]},k=s("VU/8")(w,b,!1,null,null,null).exports,I={name:"orderDetails",props:["userID"],data:function(){return{orders:[],message:null}},created:function(){this.fetchOrder(this.$route.params.id)},methods:{fetchOrder:function(t){var e=this;fetch("http://192.168.0.15/~user16/rest/client/api/orders/"+t).then(function(t){if(t.ok)return t.json();throw new Error("Network response was not ok")}).then(function(t){t.data.forEach(function(t){e.orders.push({id:t.id,car:t.model,name:t.name,date:t.date,price:t.price})})}).catch(function(t){e.message=t})}}},x={render:function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},t._l(t.orders,function(e){return s("div",{key:e.id,staticClass:"row top-buffer"},[s("div",{staticClass:"col-sm-4"}),t._v(" "),s("div",{staticClass:"col-sm-8",staticStyle:{"text-align":"left"}},[s("h4",{staticStyle:{color:"grey"}},[t._v(t._s(e.name)+" bought "+t._s(e.car))]),t._v(" "),s("p",[t._v("date: "),s("b",[t._v(t._s(e.date))])]),t._v(" "),s("p",[t._v("price: "),s("b",[t._v("$"+t._s(e.price))])])])])}))},staticRenderFns:[]},D=s("VU/8")(I,x,!1,null,null,null).exports,S={render:function(){var t=this.$createElement;return(this._self._c||t)("div",{staticClass:"container"},[this._v("\n  "+this._s(this.message)+"\n")])},staticRenderFns:[]},B=s("VU/8")({name:"carDetails",props:["userID"],data:function(){return{message:"Thank You User "+this.userID+" for order!"}},created:function(){},methods:{}},S,!1,null,null,null).exports;r.a.use(l.a);var F=new l.a({mode:"history",routes:[{path:"/",name:"Home",component:d},{path:"/thank-you",name:"Thankyou",component:B},{path:"/login",name:"Login",component:_},{path:"/register",name:"Register",component:k},{path:"/orders",name:"Orders",component:y},{path:"/orders/:id",name:"OrderDetails",component:D},{path:"/:id",name:"CarDetails",component:h}]});r.a.use(o.a),r.a.config.productionTip=!1,new r.a({el:"#app",router:F,components:{App:n},template:"<App />"})}},["NHnr"]);
//# sourceMappingURL=app.0e7b8041a636ea8a8634.js.map