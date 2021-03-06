<?php
$this->title = 'แจ้งปัญหา';
?>
<h3>แจ้งปัญหา</h3>
<hr>
<div id="app">
    <form
            id="app"
            @submit="checkForm"
            action="<?= \yii\helpers\Url::to(['/report-problem/problem'])?>"
            method="post"
            class="form-problem">
        <div v-if="message" class="alert alert-success"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{message}}</div>
        <div v-if="errors.length" class="alert alert-danger alert-dismissible fade in">
            <div v-for="error in errors">{{ error }}</div>
        </div>
        <div>
            <label for="title"><span style="color:#F44336;">*</span> ชื่อเรื่องร้องเรียยน</label>
            <input class="form-control" type="text" v-model="title" name="title" id="title">
        </div>
        <div>
            <label for="detail"><span style="color:#F44336;">*</span> รายละเอียด</label>
            <textarea class="form-control" id="detail" v-model="detail" name="detail"></textarea>
        </div>
        <div>
            <label for="name"><span style="color:#F44336;">*</span> ชื่อผู้แจ้ง</label>
            <input class="form-control" type="text" v-model="name" name="name" id="name">
        </div>
        <div>
            <label for="tel"><span style="color:#F44336;">*</span> เบอร์โทรศัพท์ผู้ร้องเรียน</label>
            <input class="form-control" type="text" v-model="tel" name="tel" id="tel">
        </div>
        <div>
            <button class="btn btn-primary">แจ้งปัญหา</button>
        </div>
    </form>
    <hr>
    <div>
        <div v-for="v in datas" v-bind:key="v.id"class="box">
            <div >
                <div>
                    <label>ชื่อเรื่องร้องเรียยน:</label>{{v.title}}
                    <label>ชื่อผู้แจ้ง:</label>{{v.name}}
                    <label>เบอร์โทร:</label>{{v.tel}}
                    <label>เวลา:</label>{{v.date}}
                    <label v-if="v.status == 1">จัดการปัญหาแล้ว</label>
                    <label v-else>ยังไม่จัดการปัญหา</label>
                </div>
                <div>
                    {{v.detail}}
                </div>
            </div>
        </div>
    </div>
</div>
<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    .form-problem input , .form-problem textarea {
       margin-bottom: 15px;
    }
    .box{
        background:gray;
        margin-bottom:15px;
        padding:10px;
        border-radius:3px;
        color:#fff;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>

<?php \richardfan\widget\JSRegister::begin();?>
<script>
    var app = new Vue({
        el: '#app',
        data: {
            errors: [],
            title:null,
            detail:null,
            name:null,
            tel:null,
            datas:[],
            message:null,
        },
        beforeMount(){
           this.fetchData();
        },
        methods:{
            clearForm:function(){
                this.title = null;
                this.detail = null;
                this.name = null;
                this.tel = null;
            },
            fetchData: async function(){
                console.log('fetch data');
                this.errors = [];
                try{
                    let url = '<?= \yii\helpers\Url::to(['/report-problem/get-problem'])?>';
                    let results = await axios({
                        method: 'get',
                        url: url
                    });
                    let {data} = results;
                    if(data.status == 'success'){
                        this.datas = data.data;
                    }
                }catch(ex){
                    this.errors.push('เออเร่อ',ex);
                }
            },
            saveData: async function(datas){
                this.errors = [];
                try{
                    let url = '<?= \yii\helpers\Url::to(['/report-problem/problem'])?>';
                    const params = new FormData();
                    params.append('datas', JSON.stringify(datas));
                    let result = await  axios({
                        method: 'post',
                        url: url,
                        data: params
                    });
                    let {data} = result;
                    if(data.status == 'success'){
                        console.log('save success');
                        this.message = data.message;
                        this.fetchData();
                        this.clearForm();
                    }
                }catch (e) {
                    this.errors.push('save',e);
                }
            },
            checkForm: function(e){
                e.preventDefault();
                if (this.title && this.detail && this.name && this.tel) {
                    let data = {
                        title:this.title,
                        detail:this.detail,
                        name:this.name,
                        tel:this.tel
                    };
                    this.saveData(data);
                    return true;
                }
                this.errors = [];
                if (!this.title) {
                    this.errors.push('กรุณากรอก ชื่อเรื่องร้องเรียยน.');
                }
                if (!this.detail) {
                    this.errors.push('กรุณากรอก รายละเอียด.');
                }
                if (!this.name) {
                    this.errors.push('กรุณากรอก ชื่อผู้เรียยน.');
                }
                if (!this.tel) {
                    this.errors.push('กรุณากรอก เบอร์โทรศัพท์ผู้ร้องเรียน.');
                }
                return false;


            }//checkForm
        }
    });
</script>
<?php \richardfan\widget\JSRegister::end();?>
