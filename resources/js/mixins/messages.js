


export const messages = {
  data(){
    return{
      successMsgTitle: 'success',
      warningMsgTitle:'warning',
      errorMsgTitle: 'error',
    }
  },
  methods: {
    successMsg(title=this.successMsgTitle,msg='',icon="",duration = 3000){
      this.msg(title,msg,'success',duration,offset);
    },
    warningMsg(title=this.warningMsgTitle,msg='',duration = 2000,offset=50){
      this.msg(title,msg,'warning',duration,offset);
    },
    errorMsg(title=this.errorMsgTitle,msg='',duration = 10000,offset=50){
        this.msg(title,msg,'error',duration,offset);
    },
    msg(title='',msg='',type = 'info',duration = 2000,offset=0){
      alert(title+' '+msg);
      // this.$notify({
      //   title: title,
      //   message:  msg,
      //   type: type,
      //   duration: duration,
      //   offset: offset,
      //   onClick(){
      //     this.close()
      //   }
      // })
    },
    
  },
}
