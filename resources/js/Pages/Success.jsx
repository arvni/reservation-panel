import {Box, Typography} from "@mui/material";
import Layout from "@/Layouts/Layout.jsx";

const Success = ({message}) => {
  return <Box sx={{mt: 3,mx:2,p:4, background:"rgba(255,255,255,0.7)",borderRadius:4 }}>
          <Typography>{message}</Typography>
      </Box>;
}
Success.layout=(page)=><Layout children={page}/>
export default Success;
