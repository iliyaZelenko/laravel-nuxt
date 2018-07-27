import Vue from 'vue'
// import { msg as toast } from '~/tools/helpers'
import iziToast from 'izitoast'
import VueNotifications from 'vue-notifications'
import 'izitoast/dist/css/iziToast.min.css'
import { msg } from '~/tools/helpers'

const toast = (title = '', message = '', type = 'info', timeout = 3000) => {
  if (type === VueNotifications.types.warn) type = 'warning'

  return iziToast[type]({title, message, timeout})
}

// Код добавляет виды сообщений в toast которые можно вызывать(Vue.prototype.$notify)
// через Object.assing(this, msg) не почему-то не получилось
for (let key in msg) {
  if (msg.hasOwnProperty(key)) {
    toast[key] = msg[key]
  }
}

Vue.prototype.$notify = toast

const options = {
  success: toast,
  error: toast,
  info: toast,
  warn: toast
}

Vue.use(VueNotifications, options)
