import {Application} from "@hotwired/stimulus";
import HelloController from "./controllers/hello_controller";
import LoginController from "./controllers/login_controller";

const application = Application.start();
application.register("hello", HelloController);
application.register("login", LoginController);
