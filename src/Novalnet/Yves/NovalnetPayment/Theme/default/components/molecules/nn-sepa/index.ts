import './nn-sepa.scss';
// Import the 'register' function from the Shop Application
import register from 'ShopUi/app/registry';

// Register the component
export default register(
    'nn-sepa',
    () => import(/* webpackMode: "lazy" */'./nn-sepa')
);
