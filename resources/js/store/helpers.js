import {mapActions, mapGetters, mapMutations, mapState,} from 'vuex';

export const guMapState = arrNames => ({
    ...mapState('guMap', [
        ...arrNames,
    ]),
});

export const guMapGetters = arrNames => ({
    ...mapGetters('guMap', [
        ...arrNames,
    ]),
});

export const guMapMutations = arrNames => ({
    ...mapMutations('guMap', [
        ...arrNames,
    ]),
});

export const guMapActions = arrNames => ({
    ...mapActions('guMap', [
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

export const dzoMapState = arrNames => ({
    ...mapState('dzoMap', [
        ...arrNames,
    ]),
});

export const dzoMapActions = arrNames => ({
    ...mapActions('dzoMap', [
        ...arrNames,
    ]),
});
