import { paegtmState } from './paegtm/PaegtmState';
import { paegtmMutations } from './paegtm/PaegtmMutations';
import { paegtmActions } from './paegtm/PaegtmActions';
import { paegtmGetters } from './paegtm/PaegtmGetters';

export default {
  namespaced: true,
  state: paegtmState.state,
  mutations: paegtmMutations,
  actions: paegtmActions,
  getters: paegtmGetters,
}
