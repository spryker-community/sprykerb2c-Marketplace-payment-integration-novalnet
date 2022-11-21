import './credit-card.scss';
// Import the 'register' function from the Shop Application
import register from 'ShopUi/app/registry';

// Register the component
export default register(
    'credit-card',
    () => import(/* webpackMode: "lazy" */'./credit-card')
);
