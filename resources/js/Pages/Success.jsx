import {Box, Typography} from "@mui/material";
import Layout from "@/Layouts/Layout.jsx";

const Success = ({message, showMap}) => {
    return <>
        <Box sx={{mt: 3, mx: 2, p: 4, background: "rgba(255,255,255,0.7)", borderRadius: 4}}>
            <Typography>{message}</Typography>
        </Box>
        {showMap &&
            <Box sx={{mt: 3, mx: 2, p:0, background: "rgba(255,255,255,0.7)", borderRadius: 4,width:"calc(100% - 2em)",overflow:"hidden"}}>
                <iframe
                    src="https://maps.google.com/maps?q=Bion+Genetic+laboratory,+133+Al+Ghubrah+St,+Muscat&t=&z=14&ie=UTF8&iwloc=&output=embed"
                    style={{border: "none", width: "100%", marginTop: 2, minHeight: "300px"}} allowFullScreen=""/>
            </Box>}
    </>;
}
Success.layout = (page) => <Layout children={page}/>
export default Success;
