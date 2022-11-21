import './sepa-guarantee.scss';
// Import the 'register' function from the Shop Application
import register from 'ShopUi/app/registry';

// Register the component
export default register(
    'sepa-guarantee',
    () => import(/* webpackMode: "lazy" */'./sepa-guarantee')
);
