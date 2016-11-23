--query for fetching result of search trains
select * 
from ((select t1.train_no,t1.arrival_time,t1.departure_time,t2.arrival_time,t2.departure_time,t1.dist_so_far,t2.dist_so_far,
			t1.fair_so_far,t1.fair_so_far
	from (((select train_no,arrival_time,departure_time,dist_so_far,fair_so_far,current_day from schedule where stn_code=$from)
		natural join trains_availability) t1,
	((select train_no,arrival_time,departure_time,dist_so_far,fair_so_far,current_day from schedule where stn_code=$to)
		natural join trains_availability) t2)
	where t1.train_no=t2.train_no and t1.current_day<=t2.current_day or t1.departure_time<t2.arrival_time and t1.available_day=$day) natural join(select train_no,name from trains));






SELECT * from
  ((SELECT train_no,arrival_time,departure_time,dist_so_far,fair_so_far,current_day
     from schedule where stn_code='JU') t1,
   (SELECT train_no,arrival_time,departure_time,dist_so_far,fair_so_far,current_day
    from schedule where stn_code='DEC') t2)
where t1.train_no=t2.train_no and t1.current_day<=t2.current_day OR t1.departure_time<t2.arrival_time; 