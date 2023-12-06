<template>
    <!-- Form 1 -->
<div class="form-1-container section-container">
    <div class="loader" v-if="loading"></div>
                <form action="" method="post">
                    <!-- User's Credentials  -->
                    <fieldset class="form-group border p-3" :disabled="loading">
                        


                        <legend class="w-auto px-2">Đội {{ this.elementscore.alliance==1?"Đỏ":"Xanh" }}</legend>
                        <div class="form-group ">
                            <label for="username">Số lượng bánh chưng hoàn chỉnh:</label>
                            <div class="input-group ">
                                <input type="number" v-on:input="addScore" v-model="elementscore.e_1" class="form-control ddd" >
                                <div class="input-group-append">
                                  <span class="input-group-text"  >10đ/cái</span>
                                </div>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Một thành phần nếp hoặc nhân đặt lên nồi:</label>
                            <div class="input-group ">
                                <input type="number" v-on:input="addScore" v-model="elementscore.e_2"  class="form-control" >
                                <div class="input-group-append">
                                  <span class="input-group-text" >2đ/cái</span>
                                </div>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Số lượng thanh củi được đẩy vào bếp:</label>
                            <div class="input-group ">
                                <input type="number" v-on:input="addScore" v-model="elementscore.e_3"  class="form-control" >
                                <div class="input-group-append">
                                  <span class="input-group-text" >5đ/cái</span>
                                </div>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Robot vào khu vực xem pháo hoa:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" type="checkbox" v-model="elementscore.e_4"  id="inlineCheckbox1" value="1">
                                <label class="form-check-label" for="inlineCheckbox1">Robot 1</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" type="checkbox" v-model="elementscore.e_5"  id="inlineCheckbox2" value="1">
                                <label class="form-check-label" for="inlineCheckbox2">Robot 2</label>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Robot bấm nút bắn pháo hoa:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" type="checkbox" id="inlineCheckbox1" v-model="elementscore.e_6"   value="1">
                                <label class="form-check-label" for="inlineCheckbox1">Robot 1</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" type="checkbox" id="inlineCheckbox2" v-model="elementscore.e_7"  value="1">
                                <label class="form-check-label" for="inlineCheckbox2">Robot 2</label>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Lỗi lấy cấu kiện bánh chưng của liên minh khác khi đội mình đang còn :</label>
                            <div class="input-group ">
                                <input type="number" v-on:input="addScore"  v-model="elementscore.e_8"  class="form-control" >
                                <div class="input-group-append">
                                  <span class="input-group-text" >-10đ/cái</span>
                                </div>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Lỗi Robot có hành vi cản trở đội khác thực hiện nhiệm vụ :</label>
                            <div class="input-group ">
                                <input type="number" v-on:input="addScore" v-model="elementscore.e_9"  class="form-control" >
                                <div class="input-group-append">
                                  <span class="input-group-text" >-10đ/cái</span>
                                </div>
                              </div>
                        </div>
                        <hr>
                        <h4>Tổng điểm {{tongDiem}}</h4>
                        <hr>
                        <div class="form-group ">
                            <label for="username">Đội {{ matchMatchTeams1.team.name }}:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" v-model="matchMatchTeams1.is_availaibe" type="checkbox" id="inlineCheckbox1" value="1">
                                <label class="form-check-label" for="inlineCheckbox1">Có mặt</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" v-model="matchMatchTeams1.is_banned" type="checkbox" id="inlineCheckbox2" value="1">
                                <label class="form-check-label" for="inlineCheckbox2">Truất quyền thi đấu</label>
                              </div>
                        </div>
                        <div class="form-group ">
                            <label for="username">Đội {{ matchMatchTeams2.team.name }}:</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" type="checkbox"  v-model="matchMatchTeams2.is_availaibe" id="inlineCheckbox1" value="0">
                                <label class="form-check-label" for="inlineCheckbox1">Có mặt</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" v-on:input="addScore" v-model="matchMatchTeams2.is_banned" type="checkbox" id="inlineCheckbox2" value="1">
                                <label class="form-check-label" for="inlineCheckbox2">Truất quyền thi đấu</label>
                              </div>
                        </div>
                    </fieldset>
             
                    <!-- Submit Button  -->
                    <div class="form-group row text-right">
                        <div class="col">
                            <button type="submit" @click.prevent="addScore"  class="btn btn-primary btn-customized">Cập nhập</button>
                            <button type="submit" @click.prevent="reset" class="btn btn-danger btn-customized">Reset</button>
                        </div>
                     
                    </div>
                    <div class="contact-form-success alert alert-success mt-4" v-if="success">
                        <strong>Success!</strong> cập nhập thành công.
                    </div>
    
                    <div class="contact-form-error alert alert-danger mt-4" v-if="error">
                        <strong>Error!</strong> There was an error sending your request.
                    </div>
                </form>
 
</div>
</template>

<script>
    export default {
        props: {
            match: {
                type: Object
            },
            scoreDetail: {
                type: Object
            },
            matchMatchTeams1:  {
                type: Object
            }, 
             matchMatchTeams2:  {
                type: Object
            },
            sendScoreUrl:{
                type: String
            },
        },
        data() {
            return {
                elementscore: {},
                success: false,
                error: false,
                loading: false,
                gameResult: {
                    win: false,
                    lost: false,
                },
                message: "Hello, Vue.js!"
            };
        },
        computed: {
            tongDiem() {
                let sum = 0;
                sum = this.elementscore.e_1*10 + this.elementscore.e_2*2 + this.elementscore.e_3*5 - this.elementscore.e_8*10 - this.elementscore.e_9*10;
                if(this.elementscore.e_3 >=4 ) {
                    sum = sum+ 10;
                }
                sum = sum + this.elementscore.e_4*10 + this.elementscore.e_5*10 + this.elementscore.e_6*10 +this.elementscore.e_7*10;
                if(this.elementscore.alliance == 1) 
                    this.match.red_score = sum;
                if(this.elementscore.alliance == 2) 
                    this.match.blue_score = sum;
                return sum;
                },
            },
        mounted() {
            console.log('Component mounted.');
            console.log(this.scoreDetail);
        },

        created() {
            console.log("created", this.count);
            if (this.scoreDetail) {
                this.elementscore  = { ...this.scoreDetail };
            }
           
        }, 
        
        methods: {
            
            async addScore(message) {
                this.tongDiem;
                this.loading = true; 
                await   axios.post( this.sendScoreUrl , 
                      { scoreDetail: this.elementscore , 
                        matchMatchTeams1 : this.matchMatchTeams1 ,
                        matchMatchTeams2 : this.matchMatchTeams2 ,
                       match : this.match   } ).then(
                        response => {
                                console.log(response.data +"sssss");    
                                this.success = true;    
                                this.error =false;
                            }) .catch(error => {
                                    this.errors = error.response.data,
                                    this.error = true;
                                    this.success = false;
                            }).finally(() => {
                               this.loading =  false
                    });
        },
        reset(){
                this.success = false;
                this.error =false;
                console.log("reset");  
                this.gameResult = {
                    win: true,
                    lost: true,
                };
                this.message = "ddd";
                console.log(this.success);  
        }
        
    }
    }
</script>

<style scoped>
input {     margin-right: 20px;}
.form-group {
    margin-bottom: 2px;
}
label , h4,hr {margin-bottom: 2px !important; }
.loader{  /* Loader Div Class */
    position: absolute;
    top:0px;
    right:0px;
    width:100%;
    height:100%;
    background-color:#eceaea;
    background-image: url('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/ajax-loader.gif');
    background-size: 50px;
    background-repeat:no-repeat;
    background-position:center;
    z-index:10000000;
    opacity: 0.4;
    filter: alpha(opacity=40);
}
</style>