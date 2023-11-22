import {Head} from "@inertiajs/react";
import {Container, CssBaseline} from "@mui/material";

const Layout = ({children}) => {
    return <>
        <Head title="Welcome"/>
        <Container component="main" maxWidth="xs" sx={{
            flexDirection:"column",
            paddingX:".5em",
            display: "flex",
            justifyContent: "flex-start",
            alignItems: "flex-start",
            background:"url(/images/bg.jpg)",
            backgroundSize:"100% 100dvh",
            paddingTop:"clamp(100px,max(17dvh,120px),225px)",
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
