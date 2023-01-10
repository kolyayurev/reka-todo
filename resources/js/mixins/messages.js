


export const messages = {
  data(){
    return{
      successMsgTitle: 'success',
      warningMsgTitle:'warning',
      errorMsgTitle: 'error',
    }
  },
  methods: {
    successMsg(title=this.successMsgTitle,msg=''){
      this.msg(title,msg,'success');
    },
    warningMsg(title=this.warningMsgTitle,msg=''){
      this.msg(title,msg,'warning');
    },
    errorMsg(title=this.errorMsgTitle,msg=''){
        this.msg(title,msg,'error');
    },
    msg(title='',msg='',type = 'info',){
      alert(title+'. '+msg);
    },
    
  },
}
