import { mount } from "@vue/test-utils";
import Setup from '../../Config/setup.js';
import ExcelForm from '@/visualcenter3/importForm/ExcelForm.vue';

describe('ExcelForm component', () => {
    it('chemistry block is visible', () => {
        const wrapper = mount(ExcelForm, {
            mocks: {
                localeUrl: () => {'/dzo_chemistry_excel_form'},
            }
        });
        expect(wrapper
            .find('#chemistryButton')
            .isVisible())
            .toBe(true)
    });
});