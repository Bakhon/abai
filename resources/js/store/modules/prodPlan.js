import { prodPlanState } from './prod-plan/ProdPlanState';
import { prodPlanMutations } from './prod-plan/ProdPlanMutations';
import { prodPlanActions } from './prod-plan/ProdPlanActions';
import { prodPlanGetters } from './prod-plan/ProdPlanGetters';

export default {
    namespaced: true,
    state: prodPlanState.state,
    mutations: prodPlanMutations,
    actions: prodPlanActions,
    getters: prodPlanGetters,
}
