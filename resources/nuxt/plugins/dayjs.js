import Vue from 'vue'
import dayjs from 'dayjs'
import 'dayjs/locale/ru'
import relativeTime from 'dayjs/plugin/relativeTime'

// import utcPlugin from 'dayjs/plugin/utc'
// dayjs.extend(utcPlugin)

dayjs.locale('ru') // use Spanish locale globally
dayjs.extend(relativeTime)

Vue.prototype.$dayjs = dayjs

// console.log(Vue.prototype.$dayjs().from(dayjs('1990')))
