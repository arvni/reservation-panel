import {Box, Button, Typography} from "@mui/material";
import Layout from "@/Layouts/Layout.jsx";
import {router} from "@inertiajs/react";

const Success = () => {
    const handleRedirect=()=>router.visit("/");
  return <Box sx={{mt: 3,mx:2,p:4, background:"rgba(255,255,255,0.7)",borderRadius:4, width:"100%",textAlign:"center" }}>
          <Typography >404</Typography>
          <Typography my={1}>Not Found</Typography>
          <Button variant={"contained"} onClick={handleRedirect}>Home</Button>
      </Box>;
}
Success.layout=(page)=><Layout children={page}/>
export default Success;
