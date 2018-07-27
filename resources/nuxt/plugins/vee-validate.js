import Vue from 'vue'
import VeeValidate, { Validator } from 'vee-validate'
import dictionary from '~/i18n/validator'

import { getLocale } from '~/tools/helpers'
import ru from 'vee-validate/dist/locale/ru' // TODO здесь менять чтобы изменился язык

const locale = getLocale()

Validator.localize(locale, ru)
Vue.use(VeeValidate, {
  locale,
  dictionary
})
