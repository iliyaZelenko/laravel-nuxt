import { rules, validator } from '~/tools/Validator'

export default {
  data: () => ({
    validatorRules: rules
  }),
  methods: {
    async validateByMixin (data) {
      const valid = await this.$validator.validateAll(data)

      return valid
    }
  },
  computed: {
    validator () {
      return validator
    }
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
