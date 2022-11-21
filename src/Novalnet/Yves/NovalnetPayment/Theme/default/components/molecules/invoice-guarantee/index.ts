import './invoice-guarantee.scss';
// Import the 'register' function from the Shop Application
import register from 'ShopUi/app/registry';

// Register the component
export default register(
    'invoice-guarantee',
    () => import(/* webpackMode: "lazy" */'./invoice-guarantee')
);
