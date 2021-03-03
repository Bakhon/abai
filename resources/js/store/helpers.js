import {mapActions, mapGetters, mapMutations, mapState,} from 'vuex';

// Map

export const guMapState = arrNames => ({
    ...mapState('gumap', [
        ...arrNames,
    ]),
});

export const guMapGetters = arrNames => ({
    ...mapGetters('gumap', [
        ...arrNames,
    ]),
});

export const guMapMutations = arrNames => ({
    ...mapMutations('gumap', [
        ...arrNames,
    ]),
});

export const guMapActions = arrNames => ({
    ...mapActions('gumap', [
        ...arrNames,
    ]),
});

export const bdFormState = arrNames => ({
    ...mapState('bdform', [
        ...arrNames,
    ]),
});

export const bdFormActions = arrNames => ({
    ...mapActions('bdform', [
        ...arrNames,
    ]),
});

// End Map