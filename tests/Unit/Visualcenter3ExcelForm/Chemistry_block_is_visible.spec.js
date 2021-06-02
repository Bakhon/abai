import { mount } from "@vue/test-utils";
import Setup from '../../Config/setup.js';
import ExcelForm from '@/visualcenter3/importForm/ExcelForm.vue';

let wrapper = null;

beforeEach( () => {
    wrapper = mount(ExcelForm, {
        mocks: {
            localeUrl: () => {'/dzo-chemistry-excel-form'},
        }
    });
});

afterEach( () => {
    wrapper.destroy();
})

describe('ExcelForm component', () => {
    it('chemistry button is visible', () => {
        expect(wrapper
            .find('#chemistryButton')
            .isVisible())
            .toBe(true)
    });
});