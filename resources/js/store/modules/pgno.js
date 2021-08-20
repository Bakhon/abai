import { pgnoState } from './pgno/PgnoState';
import { pgnoMutations } from './pgno/PgnoMutations';
import { pgnoActions } from './pgno/PgnoActions';
import { pgnoGetters } from './pgno/PgnoGetters';

export default {
    namespaced: true,
    state: pgnoState.state,
    mutations: pgnoMutations,
    actions: pgnoActions,
    getters: pgnoGetters,
}
