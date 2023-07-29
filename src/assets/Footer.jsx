import {Link} from "react-router-dom";

export const Footer = () => {

    return (

            <footer>
                {/*<Link to="/list" className={"nav"}>My List</Link> <Link to="/calendar" className={"nav"}>My Calendar</Link> /!* les liens vers les différentes pages (to = href) *!/*/}
                <Link to="/"><i className="fa-solid fa-house"></i></Link>
                <Link to="/EventPage"><i className="fa-solid fa-calendar-check"></i></Link>
                <Link to="/GamePage"><i className="fa-solid fa-dice"></i></Link>
            </footer>
    );


};


