// import { fn } from '@storybook/test';
import AddLink from '../../assets/react/controllers/AddLink';
// import { Button } from './Button';

export default {
  component: AddLink,
};

/*
 *👇 Render functions are a framework specific feature to allow you control on how the component renders.
 * See https://storybook.js.org/docs/api/csf
 * to learn how to use render functions.
 */
export const Default = {
  render: () => <AddLink fullName="Jean-Michel" />,
};
