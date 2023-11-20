import {Head} from "@inertiajs/react";
import {Container, CssBaseline} from "@mui/material";

const Layout = ({children}) => {
    return <>
        <Head title="Welcome"/>
        <Container component="main" maxWidth="xs" sx={{
            paddingX:".5em",
            display: "flex",
            justifyContent: "center",
            alignItems: "flex-start",
            background:"url(/images/background.jpg)",
            backgroundSize:"100% 100dvh",
            paddingTop:"clamp(55px,20%,200px)",
            height:"100dvh",
            width:"100dvw",
            overflowY:"auto"
        }}>
            <CssBaseline/>
            {children}
        </Container>
    </>
}
export default Layout;
