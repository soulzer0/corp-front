<template>
 
  <p>Curent time is {{ this.time }}</p>
 
</template>

<script>
export default {
  name: 'Clock',
  data:function() {
    return {
        time: '',
        date: '',
        week: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']
        }
    },
    methods: {
        zeroPadding:function (num, digit) {
            var zero = '';
            for(var i = 0; i < digit; i++) {
                zero += '0';
            }
            return (zero + num).slice(-digit);
        },
        updateTime:function() {
            var cd = new Date();
            this.time = this.zeroPadding(cd.getHours(), 2) +':' + this.zeroPadding(cd.getMinutes(), 2);
            this.date = this.zeroPadding(cd.getFullYear(), 4) + '-' + this.zeroPadding(cd.getMonth()+1, 2) + '-' + this.zeroPadding(cd.getDate(), 2) + ' ' + this.week[cd.getDay()];
        }

       
    },
    created(){
        setInterval(()=> this.updateTime(), 1 );
    }
}
</script>
<style>
#loginForm,
#signupForm {
  width: 40%;
  height: max-content;
}
</style>