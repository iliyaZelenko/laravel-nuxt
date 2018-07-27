const prefix = 'mixinsHelperScroll_' // префикс $_ не работает как писали в советах стиля, компонент не видит переменную, это очень странно, разбирался с эти 30-60 мин

// !!! Те у которых префикс $_ ($ и _ тоже вроде) не проксируются, поэтмоу к ним нужно обращатся напрямую через $data и еще они что-то не реактивны по видимому

export default {
  data: () => ({
    // scrolled: null
    [`${prefix}scrolled`]: null
    // [prefix + 'scrolled']: null
  }),
  // methods: {
  //   async validateByMixin (data) {
  //     const valid = await this.$validator.validateAll(data)
  //
  //     return valid
  //   }
  // },
  // computed: {
  //   validator () {
  //     return validator
  //   }
  // },
  beforeMount () {
    window.addEventListener('scroll', () => {
      this[prefix + 'scrolled'] = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop)
    })
  }
}

// return new Promise(async (resolve, reject) => {
//   try {
//     const valid = await this.$validator.validateAll(data)
//
//     if (!valid) {
//       let errorMsg = ''
//       for (let err of this.validator.errors.items) {
//         errorMsg += err.msg + '\n'
//       }
//
//       resolve({
//         valid,
//         errorMsg
//       })
//       return
//     }
//
//     resolve({ valid })
//   } catch (e) {
//     reject(e)
//   }
