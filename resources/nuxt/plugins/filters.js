import Vue from 'vue'

Vue.filter('truncate', (text, stop = 15, clamp) => {
  if (!text) {
    return text
  }
  return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
})

Vue.filter('date', date => {
  if (!date) {
    return null
  }
  return Vue.prototype.$dayjs(date).format(process.env.dateFormats.main)
})

Vue.filter('datetime', date => {
  if (!date) {
    return null
  }
  return Vue.prototype.$dayjs(date).format(process.env.dateFormats.datetime)
})
