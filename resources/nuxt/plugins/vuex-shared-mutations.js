import createMutationsSharer from 'vuex-shared-mutations'

export default ({store}) => {
  createMutationsSharer({
    predicate: ['nuxtAuth/SET']
  })(store)
}
