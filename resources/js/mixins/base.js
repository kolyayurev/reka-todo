import {messages} from './messages'

export default{
    mixins: [messages],
    data(){
        return{
            prLoading: true,
        }
    },
    mounted(){
        this.prLoading = false
    },
    methods:{
        startLoading(){
            this.prLoading = true
        },
        stopLoading(){
            this.prLoading = false
        },
        postAxios(url,data,
            successCallback     = (r) => { this.successMsg(); },
            validationCallback  = (r) => { this.warningMsg('Не удалось',r.data.message);},
            errorCallback       = (r) => { this.errorMsg('Не удалось',r.data.message);},
            defaultCallback     = (r) => { this.warningMsg(); },
            catchCallback       = (e) => { this.errorMsg(); },
            finallyCallback     = (r) => {}
        ){
            this.startLoading()

            axios
                .post(url, data)
                .then(response => {
                    switch (response.data.status) {
                        case 'success':
                            successCallback(response)
                            break;
                        case 'validation':
                            validationCallback(response)
                            break;
                        case 'error':
                            errorCallback(response)
                            break;
                        default:
                            defaultCallback(response)
                    }
                })
                .catch(error => {
                    catchCallback(error)
                })
                .finally(res =>  {
                    this.stopLoading()
                    finallyCallback()
                }) 
        },
        getAxios(url,data,
            successCallback     = (r) => { this.successMsg(); },
            validationCallback  = (r) => { this.warningMsg('Не удалось',r.data.message);},
            errorCallback       = (r) => { this.errorMsg('Не удалось',r.data.message);},
            defaultCallback     = (r) => { this.warningMsg(); },
            catchCallback       = (e) => { this.errorMsg(); },
            finallyCallback     = (r) => {}
        ){
            this.startLoading()

            axios
                .get(url, data)
                .then(response => {
                    switch (response.data.status) {
                        case 'success':
                            successCallback(response)
                            break;
                        case 'validation':
                            validationCallback(response)
                            break;
                        case 'error':
                            errorCallback(response)
                            break;
                        default:
                            defaultCallback(response)
                    }
                })
                .catch(error => {
                    catchCallback(error)
                })
                .finally(res =>  {
                    this.stopLoading()
                    finallyCallback()
                }) 
        },
        deleteAxios(url,
            successCallback     = (r) => { this.successMsg(); },
            validationCallback  = (r) => { this.warningMsg('Не удалось',r.data.message);},
            errorCallback       = (r) => { this.errorMsg('Не удалось',r.data.message);},
            defaultCallback     = (r) => { this.warningMsg(); },
            catchCallback       = (e) => { this.errorMsg(); },
            finallyCallback     = (r) => {}
        ){
            this.startLoading()

            axios
                .delete(url)
                .then(response => {
                    switch (response.data.status) {
                        case 'success':
                            successCallback(response)
                            break;
                        case 'validation':
                            validationCallback(response)
                            break;
                        case 'error':
                            errorCallback(response)
                            break;
                        default:
                            defaultCallback(response)
                    }
                })
                .catch(error => {
                    catchCallback(error)
                })
                .finally(res =>  {
                    this.stopLoading()
                    finallyCallback()
                }) 
        },
        isJsonValid: function(str) {
            try {
                JSON.parse(str);
            } catch (ex) {
                return false;
            }
            return true;
        },
    }
}
  