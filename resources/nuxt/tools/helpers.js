import Vue from 'vue'
import Cookie from 'js-cookie'
// import { msg as msgForThisFile } from '~/tools/helpers'

const getFuncForShowMsg = (mainType) => (title, message, type, timeout) => {
  // Vue.prototype.$notify не будет доступен если просто записать в экспортированную переменную которую
  const notify = Vue.prototype.$notify
  notify(title, message, mainType, timeout)
}

// массив функций обозначающих тип сообщения
export const msg = {
  success: getFuncForShowMsg('success'),
  info: getFuncForShowMsg('info'),
  warn: getFuncForShowMsg('warn'),
  error: getFuncForShowMsg('error')
}

// возвращает путь флага
export function getFlag (flagName) {
  try {
    return require(`~/assets/flags/${flagName.toLowerCase()}.svg`)
  } catch (e) {
    return require('~/assets/flags/undefined.svg')
  }
}

// возвращает локаль
export function getLocale () {
  if (Cookie.get('locale')) {
    return Cookie.get('locale')
  }

  return process.env.localeDefault
}

// ставит локаль
export function setLocale (locale) {
  Cookie.set('locale', locale)
}
