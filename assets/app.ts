import './bootstrap.js';
import './styles/app.css';
import './fonts/Nunito-Regular.ttf';
import { registerReactControllerComponents } from '@symfony/ux-react';
registerReactControllerComponents(require.context('./react/', true, /\.(j|t)sx?$/));

