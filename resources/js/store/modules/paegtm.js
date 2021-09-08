import { paegtmState } from './paegtm/paegtmState';
import { paegtmMutations } from './paegtm/paegtmMutations';
import { paegtmActions } from './paegtm/paegtmActions';
import { paegtmGetters } from './paegtm/paegtmGetters';

export default {
  namespaced: true,
  state: paegtmState.state,
  mutations: paegtmMutations,
  actions: paegtmActions,
  getters: paegtmGetters,
}
